<?php

namespace App\Http\Controllers;

use App\Services\SigapDataService;

class HistoryController extends Controller
{
    public function __construct(
        protected SigapDataService $sigapDataService
    ) {
    }

    public function index()
    {
        $this->ensureAbility('review-changes');

        return view('history.index', array_merge($this->baseViewData(), [
            'pageHeading' => 'Riwayat & Laporan',
            'pageDescription' => 'Audit trail perubahan data, verifikasi, rekap laporan, dan log unduhan operasional.',
            'history' => $this->sigapDataService->history(),
            'activities' => $this->sigapDataService->recentActivities(),
            'reports' => $this->sigapDataService->reports(),
            'reportLogs' => $this->sigapDataService->reportLogs(),
        ]));
    }
}
