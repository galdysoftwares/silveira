<?php declare(strict_types = 1);

namespace App\Livewire\Summary;

use App\Models\Summary;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Parsedown;

class Show extends Component
{
    public Summary $summary;

    public string $content;

    public function mount()
    {
        $parsedown = new Parsedown();

        $this->content = $parsedown->text($this->summary->content);
    }

    #[Layout('components.layouts.app')]
    public function render(): View
    {
        return view('livewire.summary.show');
    }
}
