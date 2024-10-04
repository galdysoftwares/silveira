<?php declare(strict_types = 1);

namespace App\Livewire\Products;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Update extends Component
{
    use Toast;

    public Form $form;

    public bool $updateModal = false;

    public function render(): View
    {
        return view('livewire.products.update');
    }

    #[On('product::update')]
    public function load(int $productId): void
    {
        $product = Product::query()->whereId($productId)->firstOrFail();
        $this->form->setProduct($product);
        $this->dispatch('quill::load', $product->description)->to('quill');

        $this->form->resetErrorBag();
        $this->updateModal = true;
    }

    public function save(): void
    {
        $this->form->update();

        $this->updateModal = false;
        $this->success(__('Updated successfully.'));
        $this->dispatch('product::reload')->to('products.index');
    }

    #[On('updateDescription::updated')] // This is a custom event that is dispatched from the Quill component
    public function updatedDescription($value): void
    {
        $this->form->description = $value;
    }

    public function search(string $value = ''): void
    {
        $this->form->searchCategory($value);
    }
}
