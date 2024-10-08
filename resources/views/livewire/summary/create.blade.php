<div x-data="{ isLoading: false }" class="flex flex-col items-center justify-center w-full h-full gap-4">
    <!-- Conteúdo principal -->
    <div x-show="!isLoading" class="w-full">
        <div class="py-8 text-center">
            <h1 class="text-4xl font-bold">
                <span class="text-transparent bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 bg-clip-text">
                    Resumo de Vídeos do YouTube
                </span>
                <span class="block text-gray-200">com Inteligência Artificial</span>
            </h1>
            <p class="mt-2 text-lg text-gray-100">Resuma vídeos do YouTube em segundos</p>
        </div>
        <!-- Formulário -->
        <div class="w-full">
            <x-form id="create-resume-form" class="flex flex-col w-full"
                @submit.prevent="isLoading = true; $wire.generateResume()">
                <div class="w-full">
                    <x-input wire:model="url" placeholder="Cole a URL do vídeo aqui" />
                </div>
                <!-- Botão de submit -->
                <div class="mt-4 justify-self-center">
                    <x-button label="Resumir" type="submit" form="create-resume-form"
                        class="lg:w-[350px] font-mono bg-black hover:bg-gray-800 transition duration-300" />
                </div>
            </x-form>
        </div>
    </div>

    <!-- Loading Screen -->
    <div wire:loading>
        <div x-data="loadingScreen()" class="flex flex-col items-center justify-center space-y-8">
            <!-- Animação de Loading -->
            <div class="flex space-x-4">
                <x-loading class="text-gray-300 loading-dots" />
            </div>

            <!-- Frases de Loading -->
            <div class="text-center">
                <template x-for="(phrase, index) in phrases" :key="index">
                    <p x-show="currentPhrase === index" x-transition:enter="transition ease-out duration-500 transform"
                        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                        class="text-2xl text-gray-200">
                        <span x-text="phrase"></span>
                    </p>
                </template>
            </div>

            <!-- Subtexto -->
            <p class="text-sm text-gray-400">Estamos gerando o resumo do vídeo, isso pode levar alguns segundos...</p>
        </div>

        <!-- Script do Loading -->
        <script>
            function loadingScreen() {
                return {
                    phrases: [
                        "Aperte o cinto, estamos processando seu vídeo...",
                        "Transformando palavras em conhecimento...",
                        "A mágica está acontecendo nos bastidores...",
                        "Quase lá, o resumo está ganhando forma...",
                        "Preparando algo incrível para você...",
                    ],
                    currentPhrase: 0,

                    init() {
                        // Troca as frases a cada 2 segundos
                        this.startPhraseRotation();
                    },

                    startPhraseRotation() {
                        setInterval(() => {
                            this.currentPhrase = (this.currentPhrase + 1) % this.phrases.length;
                        }, 2000);
                    }
                }
            }
        </script>
    </div>
</div>
