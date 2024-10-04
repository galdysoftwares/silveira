<x-modal wire:model="modal"
         title="{{__('Deletion Confirmation')}}"
         subtitle="{{__('You are deleting the user :username', ['username' => $user?->name])}}">

    @error('confirmation')
    <x-alert icon="o-exclamation-triangle" class="mb-4 alert-error">
        {{ $message }}
    </x-alert>
    @enderror

    <x-input
        class="input-sm"
        label="{{__('Write `DART VADER` to confirm the deletion')}}"
        wire:model="confirmation_confirmation"
    />

    <x-slot:actions>
        <x-button label="{{__('Cancel')}}" @click="$wire.modal = false"/>
        <x-button label="{{__('Confirm')}}" class="btn-primary" wire:click="destroy"/>
    </x-slot:actions>
</x-modal>
