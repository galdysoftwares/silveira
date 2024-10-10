<div>
    <x-header title="{{ $this->summary->title }}" separator />

    <div class="shadow-2xl card bg-zinc-800 max-w-full">
        <div class="card-body">
            {!! $this->content !!}
        </div>
    </div>
</div>
