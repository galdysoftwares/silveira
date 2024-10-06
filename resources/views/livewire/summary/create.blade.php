<div class="flex flex-col items-center justify-center w-full h-full gap-4">
    <div class="py-8 text-center">
        <h1 class="text-4xl font-bold">
            <span class="text-transparent bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 bg-clip-text">
                Resumo de Vídeos do YouTube
            </span>
            <span class="block text-gray-200">com Inteligência Artificial</span>
        </h1>
        <p class="mt-2 text-lg text-gray-100">Resuma vídeos do YouTube em segundos</p>
    </div>

    <div class="w-2/3">
        <x-form wire:submit="generateResume" id="create-product-form" class="flex flex-col w-full">
            <div class="w-full">
                <x-input wire:model="url" />
            </div>
            <div class="justify-self-center">
                <x-button label="{{ __('Resumir') }}" type="submit" form="create-product-form"
                    class="lg:w-[350px] font-mono bg-black " />
            </div>
        </x-form>
    </div>

    <div>
        {{ $this->summary }}
    </div>
</div>
