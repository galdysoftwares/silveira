<?php declare(strict_types = 1);

namespace App\Livewire\Products;

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
        return view('livewire.products.create');
    }

    #[On('product::create')]
    public function open(): void
    {
        $this->form->resetErrorBag();
        $this->search();
        $this->dispatch('quill::reset')->to('quill');
        $this->createModal = true;
    }

    public function save(): void
    {
        $this->form->create();

        $this->createModal = false;
        $this->success(__('Created successfully.'));
        $this->dispatch('product::reload')->to('products.index');
    }

    #[On('description::updated')] // This is a custom event that is dispatched from the Quill component
    public function updatedDescription($value): void
    {
        $this->form->description = $value;
    }

    public function search(string $value = ''): void
    {
        $this->form->searchCategory($value);
    }
}
