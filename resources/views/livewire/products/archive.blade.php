<x-modal wire:model="modal"
         title="{{__('Archive Confirmation')}}"
         subtitle="{{__('Are you sure you want to archive the product :title?', ['title' => $product?->title])}}">

    <x-slot:actions>
        <x-button label="{{__('Cancel')}}" @click="$wire.modal = false" />
        <x-button label="{{__('Confirm')}}" class="btn-primary" wire:click="archive"/>
    </x-slot:actions>
</x-modal>
