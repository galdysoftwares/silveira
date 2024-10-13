
<x-modal wire:model="modal" title="{{__('Adicione um método de pagamento')}}" class="backdrop-blur">
    <div>
        <p class="text-sm text-gray-200">
            Cadastre um cartão de crédito <b>MasterCard</b> ou <b>Visa</b> para assinar o plano.
        </p>

        <div class="flex flex-col space-y-4 mt-4">
            {{-- Nome Impresso no Cartão --}}
            <x-input
                id='card-holder-name'
                name="name"
                placeholder="Nome impresso no cartão"
                class="bg-white card-holder-name text-gray-900 focus:outline-none placeholder:font-mono placeholder:text-gray-500 placeholder:text-sm"
                type="text"
            />

            {{-- Card Holder --}}
            <div
                class="border border-gray-300 bg-white p-3 shadow placeholder:font-mono"
                id="card-element"
                wire:ignore
            ></div>

            {{-- Errors --}}
            <div id="card-errors" class="text-red-500 mt-4"></div>

            {{-- Verificar Cartão --}}
            <div class="flex justify-center">
                <x-button
                    data-secret="{{ $intent->client_secret }}"
                    class="card-button bg-black flex w-full"
                    id="card-button"
                >
                        Assinar
                </x-button>
            </div>


            <x-slot:actions class="flex items-center justify-between w-full ">
                <x-button label="{{__('Concluir assinatura')}}" wire:click="addPaymentMethod" class="bg-black flex w-full hidden"/>
            </x-slot:actions>
        </div>

        @script
            <script>
                $wire.on("load", function(event) {
                    const stripe = Stripe('{{ env('STRIPE_KEY') }}');

                    const elements = stripe.elements();

                    const cardElement = elements.create('card', {
                        hidePostalCode: true
                    });

                    cardElement.clear();

                    cardElement.mount('#card-element');

                    const cardHolderName = document.getElementsByClassName('card-holder-name')
                    const cardButton = document.getElementById('card-button');
                    const clientSecret = cardButton.dataset.secret;

                    cardButton.addEventListener('click', async (e) => {
                        console.log('verdade?/', cardHolderName[0].value);


                        if (cardHolderName[0].value === null || cardHolderName[0].value === '') {
                            console.log('clicadoo de verdade', cardHolderName);

                            document.getElementById('card-errors').textContent = 'Faltou preencher o nome impresso no cartão.';
                            return;
                        }
                        const {
                            setupIntent,
                            error
                        } = await stripe.confirmCardSetup(
                            clientSecret, {
                                payment_method: {
                                    card: cardElement,
                                    billing_details: {
                                        name: cardHolderName.value
                                    }
                                }
                            }
                        );

                        if (error) {
                            document.getElementById('card-errors').textContent = error.message;
                        } else {
                            document.getElementById('card-errors').textContent = '';
                            // aqui significa que esta tudoc erto com o cartao
                            // pegar o metodo de pagamento adicionar ao usuario
                            // criar a assinatura
                            // fechar modal e notificar que a assinatura foi criada
                            Livewire.dispatch('subscription::card-verified');
                        }
                    });
                });
            </script>
        @endscript
    </div>
</x-modal>
