<?php declare(strict_types = 1);

use App\Livewire\Auth\Login;
use App\Models\User;
use Livewire\Livewire;

it('should render the component', function () {
    Livewire::test(Login::class)
            ->assertOk();
});

it('should be able to login', function () {
    $user = User::factory()->create([
        'email'    => 'joe@doe.com',
        'password' => 'password',
    ]);

    Livewire::test(Login::class)
            ->set('email', 'joe@doe.com')
            ->set('password', 'password')
            ->call('tryToLogin')
            ->assertHasNoErrors()
            ->assertRedirect(route('dashboard'));

    expect(auth()->user()->id)->toEqual($user->id);
    expect(auth()->check())->toBeTrue();
});

it('should show an error when the credentials are invalid', function () {
    Livewire::test(Login::class)
            ->set('email', 'joe@doe.com')
            ->set('password', 'password')
            ->call('tryToLogin')
            ->assertHasErrors(['invalidCredentials'])
            ->assertSee(trans('auth.failed'));
});

it('should make sure that rate limiting  is blocking after 5 attempts', function () {
    $user = User::factory()->create([
        'email'    => 'joe@doe.com',
        'password' => 'password',
    ]);

    for ($i = 0; $i < 5; $i++) {
        Livewire::test(Login::class)
            ->set('email', 'joe@doe.com')
            ->set('password', 'wrong-password')
            ->call('tryToLogin')
            ->assertHasErrors(['invalidCredentials']);
    }

    Livewire::test(Login::class)
        ->set('email', 'joe@doe.com')
        ->set('password', 'wrong-password')
        ->call('tryToLogin')
        ->assertHasErrors(['rateLimiter']);
});
