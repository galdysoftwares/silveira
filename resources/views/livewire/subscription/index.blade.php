<div>
    <div class="py-8 sm:py-8">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
          <x-pricing.header />
          <div class="isolate mx-auto mt-16 grid max-w-md grid-cols-1 gap-y-8 sm:mt-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
            <div class="flex flex-col justify-between rounded-3xl bg-white gap-4 p-8 ring-1 ring-gray-200 lg:mt-8 lg:rounded-r-none xl:p-10">
              <div>
                <div class="flex items-center justify-between gap-x-4">
                  <h3 id="tier-freelancer" class="text-lg font-semibold leading-8 text-gray-900">Starter</h3>
                </div>
                <p class="mt-4 text-sm leading-6 text-gray-600">Resuma até 5 vídeos por mês com funcionalidades básicas. Ideal para testar!</p>
                <p class="mt-6 flex items-baseline gap-x-1">
                  <span class="text-4xl font-bold tracking-tight text-gray-900">R$0</span>
                  <span class="text-sm font-semibold leading-6 text-gray-600">/mês</span>
                </p>
                <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-600">
                  <li class="flex gap-x-3">
                    <svg class="h-6 w-5 flex-none text-zinc-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                    </svg>
                    5 Resumos
                  </li>
                </ul>
              </div>
              <x-button class="bg-black hover:bg-white hover:text-black">Assinar</x-button>
            </div>
            <div class="flex flex-col justify-between rounded-3xl gap-4 bg-white p-8 ring-1 ring-gray-200 lg:z-10 lg:rounded-b-none xl:p-10">
              <div>
                <div class="flex items-center justify-between gap-x-4">
                  <h3 id="tier-startup" class="text-lg font-semibold leading-8 text-zinc-900">Expert</h3>
                  <p class="rounded-full bg-zinc-900/10 px-2.5 py-1 text-xs font-semibold leading-5 text-zinc-900">Mais pospular</p>
                </div>
                <p class="mt-4 text-sm leading-6 text-gray-600">Resuma até 50 vídeos e escolha o modelo de IA que quer usar.</p>
                <p class="mt-6 flex items-baseline gap-x-1">
                  <span class="text-4xl font-bold tracking-tight text-gray-900">R$50</span>
                  <span class="text-sm font-semibold leading-6 text-gray-600">/mês</span>
                </p>
                <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-600">
                  <li class="flex gap-x-3">
                    <svg class="h-6 w-5 flex-none text-zinc-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                    </svg>
                    50 Resumos
                  </li>
                  <li class="flex gap-x-3">
                    <svg class="h-6 w-5 flex-none text-zinc-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                    </svg>
                    Pode escolher entre llama, chatgpt e gemini para gerar resumos
                  </li>
                  <li class="flex gap-x-3">
                    <svg class="h-6 w-5 flex-none text-zinc-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                    </svg>
                    Suporte
                  </li>
                </ul>
              </div>
              <x-button class="bg-white text-black hover:bg-black hover:text-white">Assinar</x-button>
            </div>
            <div class="flex flex-col justify-between rounded-3xl bg-white gap-4 p-8 ring-1 ring-gray-200 lg:mt-8 lg:rounded-l-none xl:p-10">
              <div>
                <div class="flex items-center justify-between gap-x-4">
                  <h3 id="tier-enterprise" class="text-lg font-semibold leading-8 text-gray-900">Premium</h3>
                </div>
                <p class="mt-4 text-sm leading-6 text-gray-600">200 Resumos e suporte prioritário. Experiência completa!</p>
                <p class="mt-6 flex items-baseline gap-x-1">
                  <span class="text-4xl font-bold tracking-tight text-gray-900">R$120</span>
                  <span class="text-sm font-semibold leading-6 text-gray-600">/mês</span>
                </p>
                <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-600">
                  <li class="flex gap-x-3">
                    <svg class="h-6 w-5 flex-none text-zinc-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                    </svg>
                    Inclui tudo dos outros planos
                  </li>
                  <li class="flex gap-x-3">
                    <svg class="h-6 w-5 flex-none text-zinc-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                    </svg>
                    200 resumos
                  </li>
                  <li class="flex gap-x-3">
                    <svg class="h-6 w-5 flex-none text-zinc-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                      <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                    </svg>
                    Outras opções de LLM's e tipos de resumo
                  </li>
                </ul>
              </div>
              <x-button class="bg-black hover:bg-white hover:text-black">Assinar</x-button>
            </div>
          </div>
        </div>
      </div>
</div>
