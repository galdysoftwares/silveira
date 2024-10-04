<?php declare(strict_types = 1);

namespace App\Livewire\Admin\Users;

use App\Enums\Can;
use App\Helpers\Table\Header;
use App\Models\{Permission, User};
use App\Traits\Livewire\HasTable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\{Builder, Collection};
use Livewire\Attributes\{On};
use Livewire\{Component, WithPagination};

class Index extends Component
{
    use WithPagination;
    use HasTable;

    public array $search_permissions = [];

    public bool $search_trash = false;

    public Collection $permissionsToSearch;

    #region methods

    public function mount(): void
    {
        $this->authorize(Can::BE_AN_ADMIN->value);
        $this->searchPermissions();
    }

    #[On('user::deleted')]
    #[On('user::restored')]
    public function render(): View
    {
        return view('livewire.admin.users.index');
    }

    public function query(): Builder
    {
        return User::query()
        ->with('permissions')
        ->when(
            $this->search_permissions,
            fn (Builder $q) => $q->whereHas(
                'permissions',
                fn (Builder $q) => $q->whereIn('id', $this->search_permissions)
            )
        )
        ->when($this->search_trash, fn (Builder $q) => $q->onlyTrashed());

    }

    public function searchColumns(): array
    {
        return ['name', 'email'];
    }

    public function tableHeaders(): array
    {
        return [
            Header::make('id', '#'),
            Header::make('name', __('Name')),
            Header::make('email', __('Email')),
            Header::make('permissions', __('Permissions')),
            Header::make('actions', __('Actions')),
        ];
    }

    public function searchPermissions(?string $value = null): void
    {
        $this->permissionsToSearch = Permission::query()
                ->when(
                    $value,
                    fn (Builder $q) => $q->where(
                        'key',
                        '%' . $value . '%'
                    )
                )
                ->orderBy('key')
                ->get();
    }

    public function showUser(int $id): void
    {
        $this->dispatch('user::show', id: $id)->to('admin.users.show');
    }

    public function updatedPerPage($value): void
    {
        $this->resetPage();
    }

    public function destroy(int $id): void
    {
        $this->dispatch('user::deletion', userId: $id)->to('admin.users.delete');
    }

    public function impersonate(int $id): void
    {
        $this->dispatch('user::impersonation', userId: $id)->to('admin.users.impersonate');
    }

    public function restore(int $id): void
    {
        $this->dispatch('user::restoring', userId: $id)->to('admin.users.restore');
    }
    #endregion methods
}
