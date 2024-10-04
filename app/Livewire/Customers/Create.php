<?php declare(strict_types = 1);

namespace App\Livewire\Customers;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\{On};
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;

    /** @var \App\Livewire\Customers\Form $form */
    public Form $form;

    public bool $createModal = false;

    public function render(): View
    {
        return view('livewire.customers.create');
    }

    #[On('customer::create')]
    public function open(): void
    {
        $this->form->resetErrorBag();
        $this->createModal = true;
    }

    public function save(): void
    {
        $this->form->create();

        $this->createModal = false;
        $this->success(__('Created successfully.'));
        $this->dispatch('customer::reload')->to('customers.index');
    }
}
