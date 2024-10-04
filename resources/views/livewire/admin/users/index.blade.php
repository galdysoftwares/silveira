<div>
    <x-header title="Users" />

    <div class="flex items-center mb-4 space-x-4">
        <div class="w-1/3">
            <x-input label="{{__('Search by name or email')}}" icon="o-magnifying-glass" wire:model.live="search"
                placeholder="{{__('Search users...')}}" />
        </div>

        <x-choices label="{{__('Permissions')}}" wire:model.live="search_permissions" :options="$permissionsToSearch" option-label="key"
            search-function="searchPermissions" searchable />

        <x-checkbox label="{{__('Show Deleted Users')}}" wire:model.live="search_trash" right />

        <x-select wire:model.live="perPage" :options="[
            ['id' => 5, 'name' => 5],
            ['id' => 15, 'name' => 15],
            ['id' => 25, 'name' => 25],
            ['id' => 50, 'name' => 50],
        ]" label="{{__('Records Per Page')}}" />
    </div>

    <x-table :headers="$this->headers" :rows="$this->items" class="mb-4">
        @scope('header_id', $header)
            <x-table.th :$header name="id" />
        @endscope

        @scope('header_name', $header)
            <x-table.th :$header name="{{__('name')}}" />
        @endscope

        @scope('header_email', $header)
            <x-table.th :$header name="{{__('email')}}" />
        @endscope


        @scope('cell_permissions', $user)
            @foreach ($user->permissions as $permission)
                <x-badge :value="$permission->key" class="badge-primary" />
            @endforeach
        @endscope

        @scope('actions', $user)
            <div class="flex items-center justify-center gap-2">
                <x-button id="show-btn-{{ $user->id }}" wire:key="show-btn-{{ $user->id }}" icon="o-eye"
                    wire:click="showUser({{ $user->id }})" spinner class="btn-sm" />
                @can(\App\Enums\Can::BE_AN_ADMIN->value)
                    @unless ($user->trashed())
                        @unless ($user->is(auth()->user()))
                            <x-button id="delete-btn-{{ $user->id }}" wire:key="delete-btn-{{ $user->id }}" icon="o-trash"
                                wire:click="destroy('{{ $user->id }}')" spinner class="btn-sm" />
                        @endunless
                        <x-button id="impersonate-btn-{{ $user->id }}" wire:key="impersonate-btn-{{ $user->id }}" icon="o-video-camera"
                            wire:click="impersonate({{ $user->id }})" spinner class="btn-sm" />
                    @else
                        <x-button icon="o-arrow-path-rounded-square" wire:click="restore({{ $user->id }})" spinner
                            class="btn-sm btn-success btn-ghost" />
                    @endunless
                @endcan
            </div>
        @endscope
    </x-table>

    {{ $this->items->links(data: ['scrollTo' => false]) }}

    <livewire:admin.users.delete />
    <livewire:admin.users.restore />
    <livewire:admin.users.show />
    <livewire:admin.users.impersonate/>
</div>
