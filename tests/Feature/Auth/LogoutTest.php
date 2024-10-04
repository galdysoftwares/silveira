<?php declare(strict_types = 1);

use App\Livewire\Auth\Logout;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('should be able to logout', function () {
    $user = User::factory()->create();

    actingAs($user);

    Livewire::test(Logout::class)
        ->call('logout')
        ->assertRedirect(route('login'));

    expect(auth()->check())->toBeFalse();
    expect(auth())->guest()->toBeTrue();
});
