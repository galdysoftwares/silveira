<?php declare(strict_types = 1);

namespace App\Livewire\Products;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Archive extends Component
{
    use Toast;

    public Product $product;

    public bool $modal = false;

    public function render(): View
    {
        return view('livewire.products.archive');
    }

    #[On('product::archive')]
    public function confirmAction(int $id): void
    {
        $this->product = Product::findOrFail($id);
        $this->modal   = true;
    }

    public function archive(): void
    {
        $this->product->delete();
        $this->modal = false;
        $this->success(__('Archived successfully.'));
        $this->dispatch('product::reload')->to('products.index');
    }
}
