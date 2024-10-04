<?php declare(strict_types = 1);

use App\Listeners\Auth\CreateValidationCode;
use App\Livewire\Auth\{EmailValidation, Register};
use App\Models\User;
use App\Notifications\Auth\ValidationCodeNotification;
use App\Notifications\WelcomeNotification;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\{Event, Notification};
use Livewire\Livewire;

use function Pest\Laravel\{actingAs, get};
use function PHPUnit\Framework\assertTrue;

beforeEach(function () {
    Notification::fake();
});

describe('after registration', function () {

    it('should send a validation code to the new users email', function () {
        $user     = User::factory()->create(['email_verified_at' => null, 'validation_code' => null]);
        $event    = new Registered($user);
        $listener = new CreateValidationCode();
        $listener->handle($event);

        Notification::assertSentTo(
            $user,
            ValidationCodeNotification::class
        );
    })->group('auth');

    it('should create a new validation code and save in the users table', function () {
        $user     = User::factory()->create(['email_verified_at' => null, 'validation_code' => null]);
        $event    = new Registered($user);
        $listener = new CreateValidationCode();
        $listener->handle($event);

        $user->refresh();

        expect($user->validation_code)->not->toBeNull()
            ->and($user->validation_code)->toBeNumeric();
        assertTrue(strlen((string)$user->validation_code) === 6);
    });

    it('making sure that the listener to send the code is linked to the registered event', function () {
        Event::fake();
        Event::assertListening(Registered::class, CreateValidationCode::class);
    });

});

describe('validation page', function () {
    it('should redirect to the validation page after registration', function () {
        Livewire::test(Register::class)
        ->set('name', 'John Doe')
        ->set('email', 'jhon@doe.com')
        ->set('email_confirmation', 'jhon@doe.com')
        ->set('password', 'password')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertRedirect(route('auth.email-validation'));
    });

    it('should check if the code is valid', function () {
        $user = User::factory()->withValidationCode()->create();

        actingAs($user);

        Livewire::test(EmailValidation::class)
            ->set('code', '000000')
            ->call('handle')
            ->assertHasErrors(['code' => 'Invalid code']);
    });

    it('should to send a new code to the user', function () {
        $user    = User::factory()->withValidationCode()->create();
        $oldCode = $user->validation_code;

        actingAs($user);

        Livewire::test(EmailValidation::class)
            ->call('sendNewCode')
            ->assertHasNoErrors();

        $user->refresh();

        expect($user->validation_code)->not->toBe($oldCode);
        Notification::assertSentTo(
            $user,
            ValidationCodeNotification::class
        );
    });

    it('should update the email_verified_at field when the code is valid', function () {
        $user = User::factory()->withValidationCode()->create();
        actingAs($user);

        Livewire::test(EmailValidation::class)
            ->set('code', $user->validation_code)
            ->call('handle')
            ->assertHasNoErrors()
            ->assertRedirect(RouteServiceProvider::HOME);

        expect($user->email_verified_at)->not->toBeNull();

        Notification::assertSentTo(
            $user,
            WelcomeNotification::class
        );
    });
});

describe('middleware', function () {
    it('should redirect to the validation page if the user is not verified', function () {
        $user = User::factory()->withValidationCode()->create();
        actingAs($user);

        get(route('dashboard'))
            ->assertRedirect(route('auth.email-validation'));
    });

});
