<?php declare(strict_types = 1);

namespace App\Livewire\Customers;

use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Update extends Component
{
    use Toast;

    /** @var \App\Livewire\Customers\Form $form */
    public Form $form;

    public bool $updateModal = false;

    public function render(): View
    {
        return view('livewire.customers.update');
    }

    #[On('customer::update')]
    public function load(int $customerId): void
    {
        $customer = Customer::query()
                        ->findOrFail($customerId);
        $this->form->setCustomer($customer);
        $this->form->resetErrorBag();
        $this->updateModal = true;
    }

    public function save(): void
    {
        $this->form->update();

        $this->updateModal = false;
        $this->success(__('Updated successfully.'));
        $this->dispatch('customer::reload')->to('customers.index');
    }
}
