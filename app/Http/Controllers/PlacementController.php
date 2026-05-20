<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlacementUpsertRequest;
use App\Models\Placement;
use App\Services\FirebaseRealtimeDatabaseService;
use App\Services\SigapDataService;
use Illuminate\Http\RedirectResponse;

class PlacementController extends Controller
{
    public function __construct(
        protected SigapDataService $sigapDataService,
        protected FirebaseRealtimeDatabaseService $firebaseDatabase
    ) {
    }

    public function index()
    {
        $filters = [
            'keyword' => trim((string) request('keyword', '')),
            'status' => (string) request('status', ''),
            'per_page' => max(5, min((int) request('per_page', 10), 20)),
        ];
        $placements = $this->sigapDataService->paginatedFilteredPlacements($filters);

        return view('placements.index', array_merge($this->baseViewData(), [
            'pageHeading' => 'Penempatan',
            'pageDescription' => 'Ringkasan hunian, status mutasi, dan catatan operasional lokasi aktif.',
            'placements' => $placements,
            'activeFilters' => $filters,
            'statusOptions' => $this->sigapDataService->placementStatusOptions(),
        ]));
    }

    public function create()
    {
        $this->ensureAbility('manage-placements');

        return view('placements.create', array_merge($this->baseViewData(), [
            'pageHeading' => 'Tambah Penempatan',
            'pageDescription' => 'Input lokasi aktif, tanggal masuk, dan status penempatan.',
            'placement' => new Placement(),
            'formAction' => route('placements.store'),
            'formMethod' => 'POST',
            'refugees' => $this->sigapDataService->refugeeSelectOptions(),
            'statusOptions' => $this->sigapDataService->placementStatusOptions(),
        ]));
    }

    public function show(Placement $placement)
    {
        return view('placements.show', array_merge($this->baseViewData(), [
            'pageHeading' => 'Detail Penempatan',
            'pageDescription' => 'Informasi lokasi aktif, tanggal, status, dan keterkaitan pengungsi.',
            'placement' => $placement,
            'placementView' => $this->sigapDataService->samplePlacementById((int) $placement->id),
            'refugeeView' => $this->sigapDataService->sampleRefugeeById((int) $placement->refugee_id),
        ]));
    }

    public function store(PlacementUpsertRequest $request): RedirectResponse
    {
        $this->ensureAbility('manage-placements');

        $placement = Placement::query()->create($request->payload());
        $this->firebaseDatabase->syncPlacement(array_merge($request->payload(), ['id' => $placement->id]), $placement->id);
        $this->firebaseDatabase->pushAuditTrail([
            'refugee_id' => $placement->refugee_id,
            'field_name' => 'placement',
            'new_value' => $placement->location_name,
            'action_label' => 'Penempatan ditambahkan',
            'performed_by_name' => $this->currentActorName(),
            'reason' => 'Input penempatan baru',
        ]);

        return redirect()
            ->route('placements.index')
            ->with('status', 'Data penempatan berhasil ditambahkan.');
    }

    public function edit(Placement $placement)
    {
        $this->ensureAbility('manage-placements');

        return view('placements.edit', array_merge($this->baseViewData(), [
            'pageHeading' => 'Ubah Penempatan',
            'pageDescription' => 'Perbarui lokasi, tanggal, dan status penempatan.',
            'placement' => $placement,
            'formAction' => route('placements.update', $placement),
            'formMethod' => 'PUT',
            'refugees' => $this->sigapDataService->refugeeSelectOptions(),
            'statusOptions' => $this->sigapDataService->placementStatusOptions(),
        ]));
    }

    public function update(PlacementUpsertRequest $request, Placement $placement): RedirectResponse
    {
        $this->ensureAbility('manage-placements');

        $original = $placement->getOriginal();
        $placement->update($request->payload());
        $this->firebaseDatabase->syncPlacement(array_merge($request->payload(), ['id' => $placement->id]), $placement->id);
        $this->firebaseDatabase->pushAuditTrail([
            'refugee_id' => $placement->refugee_id,
            'field_name' => 'placement',
            'old_value' => $original['location_name'] ?? null,
            'new_value' => $placement->location_name,
            'action_label' => 'Penempatan diperbarui',
            'performed_by_name' => $this->currentActorName(),
            'reason' => 'Pembaruan penempatan',
        ]);

        return redirect()
            ->route('placements.index')
            ->with('status', 'Data penempatan berhasil diperbarui.');
    }

    public function destroy(Placement $placement): RedirectResponse
    {
        $this->ensureAbility('full-access');

        $payload = $placement->toArray();
        $placement->delete();
        $this->firebaseDatabase->deletePlacement($payload, $payload['id'] ?? null);
        $this->firebaseDatabase->pushAuditTrail([
            'refugee_id' => $payload['refugee_id'] ?? null,
            'field_name' => 'placement',
            'old_value' => $payload['location_name'] ?? null,
            'action_label' => 'Penempatan dihapus',
            'performed_by_name' => $this->currentActorName(),
            'reason' => 'Penghapusan penempatan',
        ]);

        return redirect()
            ->route('placements.index')
            ->with('status', 'Data penempatan berhasil dihapus.');
    }
}
