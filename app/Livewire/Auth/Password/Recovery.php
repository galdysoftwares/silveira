<?php declare(strict_types = 1);

namespace App\Livewire\Auth\Password;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\{Layout, Rule};
use Livewire\Component;

class Recovery extends Component
{
    public ?string $message = null;

    #[Rule(['email', 'required'])]
    public ?string $email = null;

    #[Layout('components.layouts.guest')]
    public function render(): View
    {
        return view('livewire.auth.password.recovery');
    }

    public function startPasswordRecovery(): void
    {
        $this->validate();

        Password::sendResetLink(['email' => $this->email]);

        $this->message = __('We have e-mailed your password reset link!');
    }
}
