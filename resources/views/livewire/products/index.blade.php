<div>
    <x-header title="{{__('Products')}}" />

    <div class="flex items-end justify-between mb-4">
        <div class="flex items-end w-full space-x-4">
            {{-- Search --}}
            <div class="w-1/3">
                <x-input label="{{__('Search')}}" icon="o-magnifying-glass" wire:model.live="search"
                    placeholder="{{__('Search products...')}}" />
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
            <x-button label="{{__('Create Product')}}" @click="$dispatch('product::create')" class="btn-dark" icon="o-plus" />
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

        {{-- Code --}}
        @scope('header_code', $header)
            <x-table.th :$header name="code" />
        @endscope

        {{-- Category --}}
        @scope('header_category', $header)
            <x-table.th :$header name="category" />
        @endscope

        {{-- Amount --}}
        @scope('header_amount', $header)
            <x-table.th :$header name="amount" />
        @endscope

        @scope('cell_amount', $product)
            <div class="whitespace-nowrap text-right">R$ {{ number_format($product->amount/100, 2, ',', '.') }}</div>
        @endscope
        {{-- End Amount --}}

        {{-- Actions --}}
        @scope('actions', $product)
            <div class="flex items-center justify-center gap-2">
                {{-- Archive or Restore --}}
                @unless ($product->trashed())
                    <x-button id="update-btn-{{ $product->id }}" wire:key="update-btn-{{ $product->id }}" class="btn-sm"
                        icon="o-pencil" @click="$dispatch('product::update', { productId: {{ $product->id }} })" spinner />

                    <x-button id="archive-btn-{{ $product->id }}" wire:key="archive-btn-{{ $product->id }}" class="btn-sm"
                        icon="o-trash" @click="$dispatch('product::archive', { id: {{ $product->id }} })" spinner />
                @else
                        <x-button icon="o-arrow-path-rounded-square" @click="$dispatch('product::restore', { id: {{ $product->id }} })" spinner
                            class="btn-sm btn-success btn-ghost" />
                @endunless
            </div>
        @endscope
    </x-table>

    {{ $this->items->links(data: ['scrollTo' => false]) }}

    <livewire:products.create />
    <livewire:products.update />
    <livewire:products.archive />
    <livewire:products.restore />
</div>
