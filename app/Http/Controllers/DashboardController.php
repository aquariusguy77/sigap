<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use App\Services\SigapDataService;

class DashboardController extends Controller
{
    public function __construct(
        protected SigapDataService $sigapDataService,
        protected FirebaseService $firebaseService
    ) {
    }

    public function index()
    {
        return view('dashboard.index', array_merge($this->baseViewData(), [
            'pageHeading' => 'Dashboard Operasional',
            'pageDescription' => 'Pemantauan ringkas data pengungsi, dokumen, verifikasi, dan aktivitas pembaruan.',
            'stats' => $this->sigapDataService->stats(),
            'activities' => $this->sigapDataService->recentActivities(),
            'refugees' => $this->sigapDataService->refugees()->take(5),
            'integrationConfig' => $this->firebaseService->config(),
        ]));
    }
}
