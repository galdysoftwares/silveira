<?php

use App\Http\Controllers\SummaryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome
    ');
});

Route::get('/s', [SummaryController::class, 'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
