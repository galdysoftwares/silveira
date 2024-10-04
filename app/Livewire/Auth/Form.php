<?php declare(strict_types = 1);

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Form as BaseForm;

class Form extends BaseForm
{
    public ?User $user = null;

    public ?string $name = null;

    public ?string $email = null;

    public function rules(): array
    {
        return [
            'name'  => ['required', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->user?->id, 'id')],
        ];
    }

    public function setUser(User $user): void
    {
        $this->user = $user;

        $this->name  = $user->name;
        $this->email = $user->email;
    }

    public function update(): void
    {
        $this->validate();

        if ($this->email !== $this->user->email) {
            $this->user->email_verified_at = null;
        }

        $this->user->name  = $this->name;
        $this->user->email = $this->email;

        $this->user->save();
    }
}
