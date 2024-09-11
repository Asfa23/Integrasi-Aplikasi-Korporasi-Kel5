<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FinalAsfaCobaController;
use Illuminate\Support\Facades\Route;

// Route untuk halaman depan
Route::get('/', function () {
    return view('welcome');
});

// Route untuk dashboard
Route::get('/dashboard', [FinalAsfaCobaController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [FinalAsfaCobaController::class, 'dashboard'])->name('dashboard');
    
    // Route untuk data chart
    Route::get('/chart-data', [FinalAsfaCobaController::class, 'getChartData'])->name('chart.data');
    // Route untuk mengambil data Line Chart (untuk AJAX)
    Route::get('/chart', [FinalAsfaCobaController::class, 'groupedBarChart'])->name('chart-data');

    // Route untuk mengambil data Line Chart (untuk AJAX)
    Route::get('/linechart-data', [FinalAsfaCobaController::class, 'lineChart'])->name('linechart.data');
    // Route untuk menampilkan halaman Line Chart
    Route::get('/linechart', [FinalAsfaCobaController::class, 'lineChartView'])->name('linechart.view');

});

// Route untuk data dataset
Route::get('/dataset', [FinalAsfaCobaController::class, 'index']);



// Route untuk profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Include route authentication
require __DIR__.'/auth.php';
