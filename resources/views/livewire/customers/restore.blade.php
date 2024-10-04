<x-modal wire:model="modal"
         title="{{__('Restore Confirmation')}}"
         subtitle="{{__('You are restoring customer :name', ['name' => $customer?->name])}}">

    <x-slot:actions>
        <x-button label="{{__('Cancel')}}" @click="$wire.modal = false"/>
        <x-button label="{{__('Confirm')}}" class="btn-primary" wire:click="restore"/>
    </x-slot:actions>
</x-modal>
