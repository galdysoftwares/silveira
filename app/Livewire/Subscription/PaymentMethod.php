<?php declare(strict_types = 1);

namespace App\Livewire\Subscription;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class PaymentMethod extends Component
{
    use Toast;

    public bool $modal = false;

    public User $user;

    public function mount()
    {
        $this->user = auth()->user();
    }

    #[On('subscription::payment-method')]
    public function openModal(): void
    {
        $this->modal = true;
    }

    public function addPaymentMethod(): void
    {
        $this->success(__('Metodo de pagamento registrado com sucesso'));
    }

    public function render(): View
    {
        return view('livewire.subscription.payment-method', [
            'intent' => $this->user->createSetupIntent(),
        ]);
    }
}
