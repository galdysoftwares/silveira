@props([
    'title',
    'price',
    'description',
    'features',
    'popular' => false
])

<div class="flex flex-col justify-between rounded-3xl bg-white gap-4 p-8 ring-1 ring-gray-200 {{ $popular ? 'lg:z-10' : 'lg:mt-8' }} xl:p-10">
    <div>
        <div class="flex items-center justify-between gap-x-4">
            <h3 class="text-lg font-semibold leading-8 text-gray-900">{{ $title }}</h3>
            @if($popular)
                <p class="rounded-full bg-zinc-900/10 px-2.5 py-1 text-xs font-semibold leading-5 text-zinc-900">Mais Popular</p>
            @endif
        </div>
        <p class="mt-4 text-sm leading-6 text-gray-600">{{ $description }}</p>
        <p class="mt-6 flex items-baseline gap-x-1">
            <span class="text-4xl font-bold tracking-tight text-gray-900">{{ $price }}</span>
            <span class="text-sm font-semibold leading-6 text-gray-600">/mês</span>
        </p>
        <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-600">
            @foreach ($features as $feature)
                <li class="flex gap-x-3">
                    <svg class="h-6 w-5 flex-none text-zinc-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z" clip-rule="evenodd" />
                    </svg>
                    {{ $feature }}
                </li>
            @endforeach
        </ul>
    </div>
    {{ $slot }}
</div>
