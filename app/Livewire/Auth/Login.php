<?php declare(strict_types = 1);

namespace App\Livewire\Auth;

use Illuminate\Contracts\View\{View};
use Illuminate\Support\Facades\{Auth, RateLimiter};
use Illuminate\Support\Str;
use Livewire\Attributes\{Layout, Rule};
use Livewire\Component;

class Login extends Component
{
    #[Rule(['required', 'email'])]
    public ?string $email = null;

    #[Rule(['required'])]
    public ?string $password = null;

    #[Layout('components.layouts.guest')]
    public function render(): View
    {
        return view('livewire.auth.login');
    }

    public function tryToLogin(): void
    {
        $this->validate();

        if ($this->ensureIsNotRateLimiting()) {
            return;
        }

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            RateLimiter::hit($this->throttleKey());

            $this->addError('invalidCredentials', trans('auth.failed'));

            return;
        }

        $this->redirect(route('dashboard'));
    }

    private function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }

    private function ensureIsNotRateLimiting(): bool
    {
        if (RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            $this->addError('rateLimiter', trans('auth.throttle', [
                'seconds' => RateLimiter::availableIn($this->throttleKey()),
            ]));

            return true;
        }

        return false;
    }
}
