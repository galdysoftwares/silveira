<div>
    <x-header title="{{ $this->summary->title }}" separator />

    <div class="w-full shadow-2xl card bg-zinc-800">
        <div class="card-body">
            {!! $this->content !!}
        </div>
    </div>
</div>
