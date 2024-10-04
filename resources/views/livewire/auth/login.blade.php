<x-card title="Login" shadow class="mx-auto w-[450px]">

    @if (session()->has('status'))
        <x-alert icon="o-exclamation-triangle" class="mb-4 alert-error">
            {{ session('status') }}
        </x-alert>
    @endif

    @if($errors->hasAny(['invalidCredentials', 'rateLimiter']))
        <x-alert icon="o-exclamation-triangle" class="mb-4 alert-warning">
            @error('invalidCredentials')
            <span>{{ $message }}</span>
            @enderror

            @error('rateLimiter')
            <span>{{ $message }}</span>
            @enderror
        </x-alert>
    @endif

    <x-form wire:submit="tryToLogin">
        <x-input label="{{__('Email')}}" wire:model="email"/>
        <x-input label="{{__('Password')}}" wire:model="password" type="password"/>
        <x-slot:actions>
            <div class="flex items-center justify-between w-full">
                <a wire:navigate href="{{ route('auth.register') }}" class="link link-primary">
                    {{__('I want to create an account')}}
                </a>
                <div>
                    <x-button label="{{__('Login')}}" class="btn-primary" type="submit" spinner="submit"/>
                </div>
            </div>
        </x-slot:actions>
        <div class="flex items-center justify-between w-full mt-4">
            <a wire:navigate href="{{ route('password.recovery') }}" class="link link-primary">
                {{__('I forgot my password')}}
            </a>
        </div>
    </x-form>
</x-card>
