<div>
    <x-drawer
        wire:model="modal"
        class="w-1/3"
        right
        with-close-button
        @keydown.escape.window="$wire.modal = false"
        title="{{ $user?->name }}"
    >
        @isset($this->user)
            <x-input label="{{__('Name')}}" value="{{ $this->user->name }}" readonly class="mb-4" />
            <x-input label="{{__('Email')}}" value="{{ $this->user->email }}" readonly class="mb-4" />
            <x-input label="{{__('Created At')}}" value="{{ $this->user->created_at?->format('d/m/Y H:i:s') }}" readonly class="mb-4" />
            <x-input label="{{__('Updated At')}}" value="{{ $this->user->updated_at?->format('d/m/Y H:i:s') }}" readonly class="mb-4" />
            <x-input label="{{__('Deleted At')}}" value="{{ $this->user->deleted_at?->format('d/m/Y H:i:s') }}" readonly class="mb-4" />
            <x-input label="{{__('Deleted By')}}" value="{{ $this->user->deletedBy?->name }}" readonly class="mb-4" />
            <x-input label="{{__('Permissions')}}" value="{{ $this->user->permissions->pluck('key')->join(', ') }}" readonly class="mb-4" />
        @endisset
        <x-slot:actions>
            <x-button label="{{__('Cancel')}}" @click="$wire.modal = false" class="btn-danger" />
        </x-slot:actions>
    </x-drawer>
</div>
