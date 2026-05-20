<?php

namespace App\Http\Controllers;

use App\Services\SigapDataService;

class ReportController extends Controller
{
    public function __construct(
        protected SigapDataService $sigapDataService
    ) {
    }

    public function index()
    {
        $this->ensureAbility('view-reports');

        return view('reports.index', array_merge($this->baseViewData(), [
            'pageHeading' => 'Laporan',
            'pageDescription' => 'Rekap data aktif, ekspor, prioritas verifikasi, dan log unduhan.',
            'reports' => $this->sigapDataService->reports(),
            'reportLogs' => $this->sigapDataService->reportLogs(),
        ]));
    }
}
