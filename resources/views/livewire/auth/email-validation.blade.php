<x-card title="Email Validation" shadow class="mx-auto w-[450px]">
    @if($sendNewCodeMessage)
        <x-alert icon="o-envelope" class="mb-4 alert-warning">
            {{ $sendNewCodeMessage }}
        </x-alert>
    @endif


    <x-form wire:submit="handle">
        <p>
            {{__('We sent you a code. Please check your email.')}}
        </p>
        <x-input label="Code" wire:model="code"/>

        <x-slot:actions>
            <div class="flex items-center justify-between w-full">
                <a wire:click="sendNewCode" class="link link-primary">
                    {{__('Send a new code')}}
                </a>
                <div>
                    <x-button label="{{__('Check Code')}}" class="btn-primary" type="submit" spinner="submit"/>
                </div>
            </div>
        </x-slot:actions>
    </x-form>
</x-card>
