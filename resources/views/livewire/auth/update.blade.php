<x-drawer
 @keydown.window.escape="$wire.updateUserModal = false"
 wire:model="updateUserModal" title="{{__('Update User')}}" class="w-1/3 p-4" right with-close-button wire:key="update-user">
    <x-form wire:submit="save" id="update-user-form">
        <div class="space-y-2">
            <x-input label="{{__('Name')}}" wire:model="form.name" />
            <x-input label="{{__('Email')}}" wire:model="form.email" />
        </div>
        <x-slot:actions>
            <x-button label="{{__('Cancel')}}" @click="$wire.updateUserModal = false" />
            <x-button label="{{__('Save')}}" type="submit" form="update-user-form" />
        </x-slot:actions>
    </x-form>
</x-drawer>
