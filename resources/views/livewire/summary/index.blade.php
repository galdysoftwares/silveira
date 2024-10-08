<div>
    {{-- Stop trying to control. --}}
    @foreach ($this->summaries as $summary)
        <x-card title="{{ $summary->title }}" subtitle="{{ $summary->video->url }}" shadow>
            <x-slot:menu>
                <x-button icon="o-eye" link="{{ route('summaries.show', ['summary' => $summary->id]) }}" />
                <x-button icon="o-share" />
                <x-button icon="o-heart" />
            </x-slot:menu>
        </x-card>
    @endforeach
</div>
