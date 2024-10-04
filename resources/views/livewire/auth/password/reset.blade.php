<x-card title="{{__('Password Reset')}}" shadow class="mx-auto w-[450px]">
    @if(session()->has('status'))
        <x-alert icon="o-exclamation-triangle" class="mb-4 alert-error">
            {{ session('status') }}
        </x-alert>
    @endif

    <x-form wire:submit="updatePassword">
        <x-input label="{{__('Email')}}" value="{{ $this->obfuscatedEmail }}" readonly/>
        <x-input label="{{__('Email Confirmation')}}" wire:model="email_confirmation"/>
        <x-input label="{{__('Password')}}" wire:model="password" type="password"/>
        <x-input label="{{__('Password Confirmation')}}" wire:model="password_confirmation" type="password"/>
        <x-slot:actions>
            <div class="flex items-center justify-between w-full">
                <a wire:navigate href="{{ route('login') }}" class="link link-primary">
                   {{__('Never mind, get back to login page.')}}
                </a>
                <div>
                    <x-button label="{{__('Reset')}}" class="btn-primary" type="submit" spinner="submit"/>
                </div>
            </div>
        </x-slot:actions>
    </x-form>
</x-card>
