@props([
    'status',
    'items'
])

<div class="border border-primary p-2 bg-base-200 rounded-lg" wire:key="group-{{ $status }}">
    <x-header
        title="{{__($status)}}"
        size="text-xl"
        class="px-2 pb-0 mb-2 capitalize border-b border-primary"
        subtitle="{{__('Total :count Opportunities', ['count' => $items->count()])}}"
    />
    <ul
        wire:sortable-group.item-group="{{ $status }}"
        wire:sortable-group.options="{ animation: 100 }"
        class="space-y-2 px-2"
    >
        @empty($items->count())
            <li wire:key='"opportunity-null' class="h-10 border-dashed border-primary border w-full text-center flex items-center justify-center opacity-40">
                {{__('Empty List')}}
            </li>
        @endempty
        @foreach ($items as $item)
            <li
                wire:sortable-group.item="{{ $item->id }}"
                wire:key="item-{{ $item->id }}"
                wire:sortable-group.handle
            >
                <x-card class="border-dashed border-primary border border-opacity-50 p-2 shadow-md cursor-grab">
                    {{ $item->title }}
                </x-card>
            </li>
        @endforeach
    </ul>
</div>
