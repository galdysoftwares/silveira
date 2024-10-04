<x-card title="{{__('Password Recovery')}}" shadow class="mx-auto w-[450px]">

    @if ($message)
        <x-alert icon="o-exclamation-triangle" class="mb-4 alert-success">
            <span>{{__('We have e-mailed your password reset link!')}}</span>
        </x-alert>
    @endif

    <x-form wire:submit="startPasswordRecovery">
        <x-input label="{{__('Email')}}" wire:model="email" />
        <x-slot:actions>
            <div class="flex items-center justify-between w-full">
                <a wire:navigate href="{{ route('login') }}" class="link link-primary">
                    {{__('I remember my password')}}
                </a>
                <div>
                    <x-button label="{{__('Submit')}}" class="btn-primary" type="submit" spinner="submit" />
                </div>
            </div>
        </x-slot:actions>
    </x-form>
</x-card>
