<?php declare(strict_types = 1);

use App\Livewire\Auth\Update;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('should be able to update my user data', function () {
    $user = User::factory()->create();
    actingAs($user);

    Livewire::test(Update::class)
        ->call('load', $user->id)
        ->set('form.name', 'John Doe')
        ->set('form.email', 'john@doe')
        ->call('save')
        ->assertHasNoErrors();

    expect($user->refresh()->name)->toBe('John Doe');
    expect($user->refresh()->email)->toBe('john@doe');
});

it('should not be able to update my user data with invalid data', function () {
    $user = User::factory()->create();
    actingAs($user);

    Livewire::test(Update::class)
        ->call('load', $user->id)
        ->set('form.name', '')
        ->set('form.email', 'john@doe')
        ->call('save')
        ->assertHasErrors(['form.name' => 'required']);
});

it('should not be able to update my user data with an email that already exists', function () {
    $user        = User::factory()->create();
    $anotherUser = User::factory()->create();
    actingAs($user);

    Livewire::test(Update::class)
        ->call('load', $user->id)
        ->set('form.name', 'John Doe')
        ->set('form.email', $anotherUser->email)
        ->call('save')
        ->assertHasErrors(['form.email' => 'unique']);
});

it('should be able to update my user data with the same email', function () {
    $user = User::factory()->create();
    actingAs($user);

    Livewire::test(Update::class)
        ->call('load', $user->id)
        ->set('form.name', 'John Doe')
        ->set('form.email', $user->email)
        ->call('save')
        ->assertHasNoErrors();

    expect($user->refresh()->name)->toBe('John Doe');
    expect($user->refresh()->email)->toBe($user->email);
});

it('should set email_verified_at to null when updating the email', function () {
    $user = User::factory()->create();
    actingAs($user);

    Livewire::test(Update::class)
        ->call('load', $user->id)
        ->set('form.name', 'John Doe')
        ->set('form.email', 'john@doe')
        ->call('save')
        ->assertHasNoErrors();

    expect($user->refresh()->email_verified_at)->toBeNull();
});
