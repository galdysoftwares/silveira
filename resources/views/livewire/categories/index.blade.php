<div>
    <x-header title="{{__('Categories')}}" />

    <div class="flex items-end justify-between mb-4">
        <div class="flex items-end w-full space-x-4">
            {{-- Search --}}
            <div class="w-1/3">
                <x-input label="{{__('Search by title')}}" icon="o-magnifying-glass" wire:model.live="search"
                    placeholder="{{__('Search categories...')}}" />
            </div>
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
            <x-button label="{{__('Create category')}}" @click="$dispatch('category::create')" class="btn-dark" icon="o-plus" />
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

        {{-- Actions --}}
        @scope('actions', $category)
            <div class="flex items-center justify-center gap-2">
                @unless ($category->trashed())
                    <x-button id="update-btn-{{ $category->id }}" wire:key="update-btn-{{ $category->id }}" class="btn-sm"
                        icon="o-pencil" @click="$dispatch('category::update', { categoryId: {{ $category->id }} })" spinner />

                    <x-button id="archive-btn-{{ $category->id }}" wire:key="archive-btn-{{ $category->id }}" class="btn-sm"
                        icon="o-trash" @click="$dispatch('category::archive', { id: {{ $category->id }} })" spinner />

                @else
                        <x-button icon="o-arrow-path-rounded-square" @click="$dispatch('category::restore', { id: {{ $category->id }} })" spinner
                            class="btn-sm btn-success btn-ghost" />
                @endunless
            </div>
        @endscope
    </x-table>

    {{ $this->items->links(data: ['scrollTo' => false]) }}

    <livewire:categories.create />
    <livewire:categories.update />
    <livewire:categories.archive />
    <livewire:categories.restore />
</div>
