<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    // Route Dashboard Utama (Nama: dashboard)
    Route::get('/dashboard', function () {
        $user = Auth::user();
        
        if (method_exists($user, 'hasRole') && $user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('teknisi.create'); 
    })->name('dashboard');

    // Route Alias Form Input (Nama: reports.create)
    Route::get('/reports/create', function () {
        $user = Auth::user();
        
        if (method_exists($user, 'hasRole') && $user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        
        return view('teknisi.create'); 
    })->name('reports.create');

    // Route Kirim Laporan Teknisi
    Route::post('/report/store', [ReportController::class, 'store'])->name('report.store');

    // Route Riwayat Laporan Pribadi (Khusus User / Teknisi)
    Route::get('/my-reports', [ReportController::class, 'myReports'])->name('reports.my');

    // Route Khusus Admin
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [ReportController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::delete('/report/{id}', [ReportController::class, 'destroy'])->name('admin.report.destroy');
        
        // Route Export Excel & PDF
        Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('admin.reports.export.excel');
        Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('admin.reports.export.pdf');
    });
});

require __DIR__.'/auth.php';