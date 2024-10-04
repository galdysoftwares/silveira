<x-drawer @keydown.window.escape="$wire.createModal = false" wire:model="createModal" title="{{__('Create Category')}}" class="w-1/3 p-4" right with-close-button>
    <x-form wire:submit="save" id="create-category-form">
        <div class="space-y-2">
            <x-input label="{{__('Title')}}" wire:model="form.title" />
        </div>
        <x-slot:actions>
            <x-button label="{{__('Cancel')}}" @click="$wire.createModal = false" />
            <x-button label="{{__('Save')}}" type="submit" form="create-category-form" />
        </x-slot:actions>
    </x-form>
</x-drawer>
