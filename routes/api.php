<?php declare(strict_types = 1);

use App\Http\Controllers\Api\V1\LoginController;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

#region
Route::post('/login', LoginController::class);
// Route::get('/register', RegisterController::class)->name('auth.register');
// Route::get('/email-validation', EmailValidation::class)->middleware('auth')->name('auth.email-validation');
// Route::get('/logout', fn () => auth()->logout())->name('auth.logout');
// Route::get('/password/recovery', Recovery::class)->name('password.recovery');
// Route::get('/password/reset', Reset::class)->name('password.reset');
#enregioin

Route::get('/customers', function () {
    return Customer::all();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/customers/{id}', function (Request $r) {
        return Customer::find($r->id);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
