<x-modal wire:model="modal"
         title="{{__('Você tem certeza?')}}"
         subtitle="{{__('Você tem certeza que deseja deletar o resumo :title?', ['title' => $summary?->title])}}">

    <x-slot:actions>
        <x-button label="{{__('Cancel')}}" @click="$wire.modal = false" />
        <x-button label="{{__('Confirm')}}" class="btn-primary" wire:click="delete"/>
    </x-slot:actions>
</x-modal>
