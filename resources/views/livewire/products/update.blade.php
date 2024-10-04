<x-drawer
 wire:model="updateModal" title="{{__('Update Product')}}" class="w-6/12" right with-close-button>
    <x-form wire:submit="save" id="update-product-form">
        <div class="space-y-2">

            <x-choices
                label="{{__('Category')}}"
                wire:model="form.category_id"
                :options="$this->form->categories"
                option-label="title"
                single
                searchable
            />

            <x-input label="{{__('Title')}}" wire:model="form.title" />
            <x-input label="{{__('Code')}}" wire:model="form.code" />

            <x-input
                label="{{__('Amount')}}"
                wire:model="form.amount"
                prefix="R$"
                locale="pt-BR"
                money
            />

            <div class="flex flex-col space-y-2">
                <label for="updateDescription" class="font-bold text-sm ml-1">{{__('Description')}}</label>
                <livewire:quill
                    quillId="updateDescription"
                    component="products.update"
                >
            </div>
        </div>
        <x-slot:actions>
            <x-button label="{{__('Cancel')}}" @click="$wire.updateModal = false" />
            <x-button label="{{__('Save')}}" type="submit" form="update-product-form" />
        </x-slot:actions>
    </x-form>
</x-drawer>
