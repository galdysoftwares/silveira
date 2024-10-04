<?php declare(strict_types = 1);

use App\Livewire\Auth\Password\Recovery;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;

use function Pest\Laravel\{assertDatabaseCount, assertDatabaseHas, get};

test('need to have a route  to passord recovery', function () {
    get(route('password.recovery'))
        ->assertSeeLivewire('auth.password.recovery')
        ->assertOk();
});

it('should be able to request for a password recovery', function () {
    Notification::fake();

    /** @var User $user */
    $user = User::factory()->create();

    Livewire::test(Recovery::class)
        ->assertDontSee(__('We have e-mailed your password reset link!'))
        ->set('email', $user->email)
        ->call('startPasswordRecovery')
        ->assertSee(__('We have e-mailed your password reset link!'));

    Notification::assertSentTo($user, ResetPassword::class);
});

test('email property', function ($value, $rule) {
    Livewire::test(Recovery::class)
        ->set('email', $value)
        ->call('startPasswordRecovery')
        ->assertHasErrors(['email' => $rule]);
})->with([
    'required' => ['value' => '', 'rule' => 'required'],
    'email'    => ['value' => 'invalid-email', 'rule' => 'email'],
]);

test('needs to create a token when requesting for a password recovery', function () {
    /** @var User $user */
    $user = User::factory()->create();

    Livewire::test(Recovery::class)
        ->assertDontSee('We have e-mailed your password reset link!')
        ->set('email', $user->email)
        ->call('startPasswordRecovery');

    assertDatabaseCount('password_reset_tokens', 1);
    assertDatabaseHas('password_reset_tokens', [
        'email' => $user->email,
    ]);
});
