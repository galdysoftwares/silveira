<div>
    <x-header title="{{__('Opportunities')}}" />

    <div class="flex items-end justify-between mb-4">
        <div class="flex items-end w-full space-x-4">
            {{-- Search --}}
            <div class="w-1/3">
                <x-input label="{{__('Search by title')}}" icon="o-magnifying-glass" wire:model.live="search"
                    placeholder="{{__('Search opportunities...')}}" />
            </div>
            {{-- Archived Opportunities --}}
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
            <x-button label="{{__('Create Opportunity')}}" @click="$dispatch('opportunity::create')" class="btn-dark" icon="o-plus" />
        </div>
    </div>

    <x-table :headers="$this->headers" :rows="$this->items" class="mb-4">
        {{-- ID --}}
        @scope('header_id', $header)
            <x-table.th :$header name="id" />
        @endscope

        {{-- Title --}}
        @scope('header_title', $header)
            <x-table.th :$header name="title" />
        @endscope

        @scope('header_customer', $header)
            <x-table.th :$header name="customer" />
        @endscope

        {{-- Status --}}
        @scope('header_status', $header)
            <x-table.th :$header name="status" />
        @endscope

        @scope('cell_status', $opportunity)
            <x-badge
                :value="$opportunity->status"
                @class([
                    'badge-outline text-black badge-sm',
                    'badge-info' => $opportunity->status === 'open',
                    'badge-success' => $opportunity->status === 'won',
                    'badge-error' => $opportunity->status === 'lost',
                ])
            />
        @endscope
        {{-- End Status --}}

        {{-- Amount --}}
        @scope('header_amount', $header)
            <x-table.th :$header name="amount" />
        @endscope

        @scope('cell_amount', $opportunity)
            <div class="whitespace-nowrap text-right">R$ {{ number_format($opportunity->amount/100, 2, ',', '.') }}</div>
        @endscope
        {{-- End Amount --}}

        {{-- Actions --}}
        @scope('actions', $opportunity)
            <div class="flex items-center justify-center gap-2">
                {{-- Archive or Restore --}}
                @unless ($opportunity->trashed())
                    <x-button id="update-btn-{{ $opportunity->id }}" wire:key="update-btn-{{ $opportunity->id }}" class="btn-sm"
                        icon="o-pencil" @click="$dispatch('opportunity::update', { opportunityId: {{ $opportunity->id }} })" spinner />

                    <x-button id="archive-btn-{{ $opportunity->id }}" wire:key="archive-btn-{{ $opportunity->id }}" class="btn-sm"
                        icon="o-trash" @click="$dispatch('opportunity::archive', { id: {{ $opportunity->id }} })" spinner />
                @else
                        <x-button icon="o-arrow-path-rounded-square" @click="$dispatch('opportunity::restore', { id: {{ $opportunity->id }} })" spinner
                            class="btn-sm btn-success btn-ghost" />
                @endunless
            </div>
        @endscope
    </x-table>

    {{ $this->items->links(data: ['scrollTo' => false]) }}

    <livewire:opportunities.create />
    <livewire:opportunities.update />
    <livewire:opportunities.archive />
    <livewire:opportunities.restore />
</div>
