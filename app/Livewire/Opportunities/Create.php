<?php declare(strict_types = 1);

namespace App\Livewire\Opportunities;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;

    public Form $form;

    public bool $createModal = false;

    public function render(): View
    {
        return view('livewire.opportunities.create');
    }

    #[On('opportunity::create')]
    public function open(): void
    {
        $this->form->resetErrorBag();
        $this->search();
        $this->createModal = true;
    }

    public function save(): void
    {
        $this->form->create();

        $this->createModal = false;
        $this->success(__('Created successfully.'));
        $this->dispatch('opportunity::reload')->to('opportunities.index');
    }

    public function search(string $value = ''): void
    {
        $this->form->searchCustomers($value);
    }
}
