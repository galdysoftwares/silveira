<?php declare(strict_types = 1);

namespace App\Traits\Livewire;

use App\Helpers\Table\Header;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;

trait HasTable
{
    public ?string $search = null;

    public string $sortDirection = 'asc';

    public string $sortColumnBy = 'id';

    public int $perPage = 10;

    /** @return Header[] */
    abstract public function tableHeaders(): array;
    abstract public function query(): Builder;
    abstract public function searchColumns(): array;

    #[Computed]
    public function headers(): array
    {
        return collect($this->tableHeaders())
            ->map(function (Header $header) {
                return [
                    'key'           => $header->key,
                    'label'         => $header->label,
                    'sortColumnBy'  => $this->sortColumnBy,
                    'sortDirection' => $this->sortDirection,
                ];
            })
            ->toArray();
    }

    #[Computed]
    public function items(): LengthAwarePaginator
    {
        // @phpstan-ignore-next-line
        return $this->query()->search($this->search, $this->searchColumns())->orderBy($this->sortColumnBy, $this->sortDirection)->paginate($this->perPage);
    }

    public function sortBy(string $column, string $direction): void
    {
        $this->sortColumnBy  = $column;
        $this->sortDirection = $direction;
    }
}
