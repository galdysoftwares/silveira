<?php declare(strict_types = 1);

namespace App\Livewire\Products;

use App\Helpers\Table\Header;
use App\Models\Product;
use App\Traits\Livewire\HasTable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\{Component, WithPagination};

class Index extends Component
{
    use WithPagination;
    use HasTable;

    public bool $searchTrash = false;

    #[On('product::reload')]
    public function render(): View
    {
        return view('livewire.products.index');
    }

    public function query(): Builder
    {
        return Product::query()
            ->select('products.*', 'categories.title as category_name')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->when(
                $this->searchTrash,
                fn (Builder $q) => $q->onlyTrashed()
            );
    }

    public function searchColumns(): array
    {
        return ['products.title', 'categories.title', 'amount', 'code'];
    }

    public function tableHeaders(): array
    {
        return [
            Header::make('id', '#'),
            Header::make('title', __('Title')),
            Header::make('code', __('Code')),
            Header::make('category_name', __('Category')),
            Header::make('amount', __('Amount')),
        ];
    }
}
