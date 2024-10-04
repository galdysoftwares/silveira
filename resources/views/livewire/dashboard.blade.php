<div class="p-16">
    <div class="flex flex-col gap-4 items-center justify-center w-full h-full">
        <div class="text-center py-8">
            <h1 class="text-4xl font-bold">
                <span class="bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 text-transparent bg-clip-text">
                    Resumo de Vídeos do YouTube
                </span>
                <span class="block text-gray-200">com Inteligência Artificial</span>
            </h1>
            <p class="mt-2 text-lg text-gray-100">Resuma vídeos do YouTube em segundos</p>
        </div>

        <div class="w-2/3">
            <x-form wire:submit="generateResume" id="create-product-form" class="flex w-full flex-col">
                <div class="w-full">
                    <x-input wire:model="url" />
                </div>
                <div class="justify-self-center">
                    <x-button label="{{__('Resumir')}}" type="submit" form="create-product-form" class="lg:w-[350px] font-mono bg-black "/>
                </div>
            </x-form>
        </div>
    </div>
</div>
