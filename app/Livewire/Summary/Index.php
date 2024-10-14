<?php declare(strict_types = 1);

namespace App\Livewire\Summary;

use App\Models\Summary;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public Collection $summaries;

    public function mount()
    {
        $this->summaries = $this->query();
    }

    public function query(): Collection
    {
        return Summary::query()
            ->where('summaries.user_id', auth()->id())
            ->with('video:id,description,url')
            ->orderBy('summaries.created_at', 'DESC')
            ->get();
    }

    #[On('summary::reload')]
    #[Layout('components.layouts.app')]
    public function render(): View
    {
        return view('livewire.summary.index');
    }
}
