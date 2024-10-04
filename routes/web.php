<?php

declare(strict_types = 1);

use App\Enums\Can;
use App\Http\Controllers\Webhooks\HotmartWebhookController;
use App\Livewire\Admin\Users\Index;
use App\Livewire\Auth\Password\{Recovery, Reset};
use App\Livewire\Auth\{EmailValidation, Login, Register};
use App\Livewire\{Categories, Customers, Dashboard, Opportunities, Products, Webhooks};
use App\Livewire\Admin\Welcome;
use Illuminate\Support\Facades\Route;

#region Loginflow
Route::get('/login', Login::class)->name('login');
Route::get('/register', Register::class)->name('auth.register');
Route::get('/email-validation', EmailValidation::class)->middleware('auth')->name('auth.email-validation');
Route::get('/logout', fn () => auth()->logout())->name('auth.logout');
Route::get('/password/recovery', Recovery::class)->name('password.recovery');
Route::get('/password/reset', Reset::class)->name('password.reset');
#endregion

#region Authenticated
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', Dashboard::class)->name('dashboard');

    #region Admin
    Route::prefix('/admin')->middleware('can:' . Can::BE_AN_ADMIN->value)->group(function () {
        Route::get('/', Welcome::class)->name('admin.dashboard');
        Route::get('/users', Index::class)->name('admin.users');

        #region Categories
        Route::get('/categories', Categories\Index::class)->name('admin.categories');
        #endregion

        #region Customers
        Route::get('/customers', Customers\Index::class)->name('customers');
        Route::get('/customers/{customer}', Customers\Show::class)->name('customers.show');
        #endregion

        #region Opportunities
        Route::get('/opportunities', Opportunities\Index::class)->name('opportunities');
        #endregion

        #region Products
        Route::get('/products', Products\Index::class)->name('products');
        #endregion
    });
    #endregion

});
#endregion

#region Webhooks
Route::middleware('throttle')->prefix('webhooks')->group(function () {
    Route::get('/', Webhooks\Index::class)->name('webhooks')->middleware(['auth', 'verified']);

    Route::post('hotmart', HotmartWebhookController::class)->name('webhooks.hotmart');
});
