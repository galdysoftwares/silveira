<?php declare(strict_types = 1);

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Update extends Component
{
    use Toast;

    public Form $form;

    public bool $updateUserModal = false;

    public function render(): View
    {
        return view('livewire.auth.update');
    }

    #[On('user::update')]
    public function load(int $userId): void
    {
        $user = User::query()
                        ->findOrFail($userId);
        $this->form->setUser($user);
        $this->form->resetErrorBag();
        $this->updateUserModal = true;
    }

    public function save(): void
    {
        $this->form->update();

        $this->updateUserModal = false;
        $this->success(__('Updated successfully.'));
    }
}
