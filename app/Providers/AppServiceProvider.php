<?php declare(strict_types = 1);

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // this method is used to register services into the service container
    }

    public function boot(): void
    {
        Model::preventLazyLoading();
    }
}
