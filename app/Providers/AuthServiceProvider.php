<?php declare(strict_types = 1);

namespace App\Providers;

use App\Enums\Can;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

    public function boot(): void
    {
        foreach (Can::cases() as $can) {
            Gate::define(
                $can->value,
                fn ($user) => $user->hasPermissionTo($can)
            );
        }
    }
}
