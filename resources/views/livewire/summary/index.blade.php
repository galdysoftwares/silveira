<div class="flex flex-col gap-4">
    @foreach ($this->summaries as $summary)
        <x-card title="{{ $summary->title }}" subtitle="{{ $summary->video->url }}" shadow>
            <x-slot:menu>
                <x-button icon="o-eye" link="{{ route('summaries.show', ['summary' => $summary->id]) }}" />
                <x-button id="delete-btn-{{ $summary->id }}" wire:key="delete-btn-{{ $summary->id }}"
                        icon="o-trash" @click="$dispatch('summary::delete', { id: {{ $summary->id }} })" spinner />
                <x-button icon="o-share" />
                <x-button icon="o-heart" />
            </x-slot:menu>
        </x-card>
    @endforeach

    <livewire:summary.delete />
</div>
