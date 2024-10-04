<x-drawer
 @keydown.window.escape="$wire.createModal = false"
 wire:model="createModal" title="{{__('Create Customer')}}" class="w-1/3 p-4" right with-close-button wire:key="create-customer">
    <x-form wire:submit="save" id="create-customer-form">
        <div class="space-y-2">
            <x-input label="{{__('Name')}}" wire:model="form.name" />
            <x-input label="{{__('Email')}}" wire:model="form.email" />
            <x-input label="{{__('Phone')}}" wire:model="form.phone" />
        </div>
        <x-slot:actions>
            <x-button label="{{__('Cancel')}}" @click="$wire.createModal = false" />
            <x-button label="{{__('Save')}}" type="submit" form="create-customer-form" />
        </x-slot:actions>
    </x-form>
</x-drawer>
