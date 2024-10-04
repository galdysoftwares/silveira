<?php declare(strict_types = 1);

use App\Livewire\Admin\Dashboard;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('should block users without permission to access the admin dashboard', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertForbidden();

    Livewire::test(Dashboard::class)
        ->assertForbidden();
});
