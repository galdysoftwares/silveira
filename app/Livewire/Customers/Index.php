<?php declare(strict_types = 1);

namespace App\Livewire\Customers;

use App\Helpers\Table\Header;
use App\Models\Customer;
use App\Traits\Livewire\HasTable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\{Component, WithPagination};

/**
 * @property-read LengthAwarePaginator $customers
 */
class Index extends Component
{
    use WithPagination;
    use HasTable;

    public bool $searchTrash = false;

    #[On('customer::reload')]
    public function render(): View
    {
        return view('livewire.customers.index');
    }

    public function query(): Builder
    {
        return Customer::query()->when($this->searchTrash, fn (Builder $q) => $q->onlyTrashed());
    }

    public function searchColumns(): array
    {
        return ['name', 'email', 'phone'];
    }

    public function tableHeaders(): array
    {
        return [
            Header::make('id', '#'),
            Header::make('name', __('Name')),
            Header::make('email', __('Email')),
            Header::make('phone', __('Phone')),
        ];
    }
}
