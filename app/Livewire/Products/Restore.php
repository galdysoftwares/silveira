<?php declare(strict_types = 1);

namespace App\Livewire\Products;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Restore extends Component
{
    use Toast;

    public Product $product;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.products.restore');
    }

    #[On('product::restore')]
    public function confirmAction(int $id): void
    {
        $this->product = Product::query()->onlyTrashed()->findOrFail($id);
        $this->modal   = true;
    }

    public function restore(): void
    {
        $this->product->restore();
        $this->modal = false;
        $this->success(__('Restored successfully.'));
        $this->dispatch('product::reload')->to('products.index');
    }
}
