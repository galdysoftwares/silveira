<div class="py-8 sm:py-8">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <x-subscription.header />
        <div class="isolate mx-auto mt-16 grid max-w-md grid-cols-1 gap-y-8 sm:mt-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
            <x-subscription.card
                title="Starter"
                price="R$0"
                description="Resuma até 5 vídeos por mês com funcionalidades básicas. Ideal para testar!"
                :features="['5 Resumos']">
                <x-subscription.button />
            </x-subscription.card>

            <x-subscription.card
                title="Expert"
                price="R$50"
                description="Resuma até 50 vídeos e escolha o modelo de IA que quer usar."
                :features="['50 Resumos', 'Escolha entre Llama, ChatGPT e Gemini', 'Suporte']"
                :popular="true">
                <x-subscription.button />
            </x-subscription.card>

            <x-subscription.card
                title="Premium"
                price="R$120"
                description="200 Resumos e suporte prioritário. Experiência completa!"
                :features="['200 Resumos', 'Inclui tudo dos outros planos', 'Opções avançadas de LLMs']">
                <x-subscription.button />
            </x-subscription.button>
        </div>
    </div>
</div>
