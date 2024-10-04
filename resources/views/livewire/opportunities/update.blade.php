<x-drawer
 @keydown.window.escape="$wire.updateModal = false"
 wire:model="updateModal" title="{{__('Update Opportunity')}}" class="w-1/3 p-4" right with-close-button>
    <x-form wire:submit="save" id="update-opportunity-form">
        <div class="space-y-2">
            <x-choices
                label="{{__('Customer')}}"
                wire:model="form.customer_id"
                :options="$this->form->customers"
                single
                searchable
            />
            <x-input label="{{__('Title')}}" wire:model="form.title" />
            <x-select
            label="Status"
                :options="[
                    ['id' => 'open', 'name' =>'open'],
                    ['id' => 'won', 'name' =>'won'],
                    ['id' => 'lost', 'name' =>'lost'],
                ]"
                wire:model="form.status"
            />
        <x-input label="{{__('Amount')}}" wire:model="form.amount"
                 prefix="R$" locale="pt-BR" money
                />
        </div>
        <x-slot:actions>
            <x-button label="{{__('Cancel')}}" @click="$wire.updateModal = false" />
            <x-button label="{{__('Save')}}" type="submit" form="update-opportunity-form" />
        </x-slot:actions>
    </x-form>
</x-drawer>