<x-modal wire:model="modal"
         title="{{__('Archive Confirmation')}}"
         subtitle="{{__('You are archive the category :title', ['title' => $category?->title])}}">

    <x-slot:actions>
        <x-button label="{{__('Cancel')}}" @click="$wire.modal = false" />
        <x-button label="{{__('Confirm')}}" class="btn-primary" wire:click="archive"/>
    </x-slot:actions>
</x-modal>
