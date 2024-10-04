<?php declare(strict_types = 1);

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Event;
use Livewire\Attributes\{Layout, Rule};
use Livewire\Component;

class Register extends Component
{
    #[Rule(['required', 'max:255'])]
    public ?string $name = null;

    #[Rule(['required', 'email', 'confirmed', 'unique:users,email', 'max:255'])]
    public ?string $email = null;

    public ?string $email_confirmation = null;

    #[Rule(['required', 'string', 'min:8'])]
    public ?string $password = null;

    #[Layout('components.layouts.guest')]
    public function render(): View
    {
        return view('livewire.auth.register');
    }

    public function submit(): void
    {
        $this->validate();

        $user = User::create([
            'name'     => $this->name,
            'email'    => $this->email,
            'password' => $this->password,
        ]);

        Event::dispatch(new Registered($user));

        auth()->login($user);
        $this->redirect(route('auth.email-validation'));
    }
}
