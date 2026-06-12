<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/notifications/unread-count', [ApiController::class, 'notificationCount']);
    Route::get('/pengajuan/status', [ApiController::class, 'pengajuanStatus']);
    Route::get('/dashboard/stats', [ApiController::class, 'dashboardStats']);
});
