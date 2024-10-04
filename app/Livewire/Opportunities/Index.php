<?php declare(strict_types = 1);

namespace App\Livewire\Opportunities;

use App\Helpers\Table\Header;
use App\Models\Opportunity;
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

    #[On('opportunity::reload')]
    public function render(): View
    {
        return view('livewire.opportunities.index');
    }

    public function query(): Builder
    {
        return Opportunity::query()
            ->select('opportunities.*', 'customers.name as customer_name')
            ->leftJoin('customers', 'opportunities.customer_id', '=', 'customers.id')
            ->when(
                $this->searchTrash,
                fn (Builder $q) => $q->onlyTrashed()
            );
    }

    public function searchColumns(): array
    {
        return ['title', 'customers.name', 'status'];
    }

    public function tableHeaders(): array
    {
        return [
            Header::make('id', '#'),
            Header::make('title', __('Title')),
            Header::make('customer_name', __('Customer')),
            Header::make('status', __('Status')),
            Header::make('amount', __('Amount')),
        ];
    }
}
