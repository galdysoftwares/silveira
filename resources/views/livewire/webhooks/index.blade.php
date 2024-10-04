<div>
    <x-header title="{{__('Webhooks')}}" />
    Nothing in the world is as soft and yielding as water.

    <div class="flex items-end justify-between mb-4">
        <div class="flex items-end w-full space-x-4">
            {{-- Search --}}
            <div class="w-1/3">
                <x-input label="{{__('Search')}}" icon="o-magnifying-glass" wire:model.live="search"
                    placeholder="{{__('Buscar...')}}" />
            </div>

            {{-- Per Page --}}
            <x-select wire:model.live="perPage" :options="[
                ['id' => 10, 'name' => 10],
                ['id' => 15, 'name' => 15],
                ['id' => 25, 'name' => 25],
                ['id' => 50, 'name' => 50],
            ]" label="{{__('Records Per Page')}}" />
        </div>
    </div>

    <x-table :headers="$this->headers" :rows="$this->items" class="mb-4">
        {{-- ID --}}
        @scope('header_id', $header)
            <x-table.th :$header name="id" />
        @endscope

        {{-- Title --}}
        @scope('header_provider', $header)
            <x-table.th :$header name="provider" />
        @endscope



        {{-- Actions --}}
        @scope('actions', $product)
            <div class="flex items-center justify-center gap-2">
            </div>
        @endscope
    </x-table>
    {{ $this->items->links(data: ['scrollTo' => false]) }}
</div>
