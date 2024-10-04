<?php declare(strict_types = 1);

namespace App\Livewire\Categories;

use App\Helpers\Table\Header;
use App\Models\Category;
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

    #[On('category::reload')]
    public function render(): View
    {
        return view('livewire.categories.index');
    }

    public function query(): Builder
    {
        return Category::query()
            ->select('*')
            ->when(
                $this->searchTrash,
                fn (Builder $q) => $q->onlyTrashed()
            );
    }

    public function searchColumns(): array
    {
        return ['title'];
    }

    public function tableHeaders(): array
    {
        return [
            Header::make('id', '#'),
            Header::make('title', __('Title')),
        ];
    }
}
