<?php declare(strict_types = 1);

namespace App\Livewire\Subscription;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\{On, Rule};
use Livewire\Component;
use Mary\Traits\Toast;

class PaymentMethod extends Component
{
    use Toast;

    public bool $modal = false;

    public User $user;

    #[Rule(['required'])]
    public $paymentMethod;

    #[Rule(['required', 'string', 'min:3', 'max:255'])]
    public string $name = '';

    public function mount()
    {
        $this->user = auth()->user();
        $this->dispatch('load');
    }

    #[On('subscription::payment-method')]
    public function openModal(): void
    {
        $this->modal = true;
    }

    #[On('subscription::card-verified')]
    public function addPaymentMethod($paymentMethod): void
    {
        $this->modal = false;
        $this->success(__('Metodo de pagamento registrado com sucesso'));
        dd($this->paymentMethod, 'eita');
    }

    public function render(): View
    {
        return view('livewire.subscription.payment-method', [
            'intent' => $this->user->createSetupIntent(),
        ]);
    }
}
