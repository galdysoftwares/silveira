<div>
    <x-header title="{{__('Customers')}}" />

    <div class="flex items-end justify-between mb-4">
        <div class="flex items-end w-full space-x-4">
            {{-- Search --}}
            <div class="w-1/3">
                <x-input label="{{__('Search by name or email')}}" icon="o-magnifying-glass" wire:model.live="search"
                    placeholder="{{__('Search customers...')}}" />
            </div>
            {{-- Archived Customers --}}
            <x-checkbox label="{{__('Show archived')}}" wire:model.live="searchTrash" right />
            {{-- Per Page --}}
            <x-select wire:model.live="perPage" :options="[
                ['id' => 10, 'name' => 10],
                ['id' => 15, 'name' => 15],
                ['id' => 25, 'name' => 25],
                ['id' => 50, 'name' => 50],
            ]" label="{{__('Records Per Page')}}" />
        </div>

        <div class="flex space-x-4">
            <x-button label="{{__('Create Customer')}}" @click="$dispatch('customer::create')" class="btn-dark" icon="o-plus" />
        </div>
    </div>

    <x-table :headers="$this->headers" :rows="$this->items" class="mb-4">
        @scope('header_id', $header)
            <x-table.th :$header name="id" />
        @endscope

        @scope('header_name', $header)
            <x-table.th :$header name="name" />
        @endscope

        @scope('header_email', $header)
            <x-table.th :$header name="email" />
        @endscope

        @scope('header_phone', $header)
            <x-table.th :$header name="phone" />
        @endscope

        @scope('actions', $customer)
            <div class="flex items-center justify-center gap-2">
                @unless ($customer->trashed())
                    <x-button id="update-btn-{{ $customer->id }}" wire:key="update-btn-{{ $customer->id }}" class="btn-sm"
                        icon="o-pencil" @click="$dispatch('customer::update', { customerId: {{ $customer->id }} })" spinner />

                    <x-button id="archive-btn-{{ $customer->id }}" wire:key="archive-btn-{{ $customer->id }}" class="btn-sm"
                        icon="o-trash" @click="$dispatch('customer::archive', { id: {{ $customer->id }} })" spinner />

                    <a
                        id="show-btn-{{ $customer->id }}"
                        wire:key="show-btn-{{ $customer->id }}"
                        href="{{ route('customers.show', $customer) }}"
                        class="btn btn-sm normal-case"
                    >
                        <x-icon name="o-eye" />
                    </a>
                @else
                    <x-button icon="o-arrow-path-rounded-square" @click="$dispatch('customer::restore', { id: {{ $customer->id }} })" spinner
                            class="btn-sm btn-success btn-ghost" />
                @endunless
            </div>
        @endscope
    </x-table>

    <div class="mt-4">
        {{ $this->items->links(data: ['scrollTo' => false]) }}
    </div>

    <livewire:customers.create />
    <livewire:customers.update />
    <livewire:customers.archive />
    <livewire:customers.restore />
</div>
