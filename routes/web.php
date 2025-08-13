<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProximityAlertController;
use App\Events\LocationUpdated;
use App\Http\Controllers\ProximityHistoryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/proximity-form', function () {
    return view('dashboard.form');
});

Route::post('/check-proximity', [ProximityAlertController::class, 'checkProximity'])->name('check.proximity');

Route::get('/send-location', function () {
    broadcast(new LocationUpdated(14.6, 120.98, 0.5, true));
    return "Location sent";
});

Route::get('/proximity-history', [ProximityHistoryController::class, 'index'])->name('proximity.history');
