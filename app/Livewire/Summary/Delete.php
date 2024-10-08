<?php declare(strict_types = 1);

namespace App\Livewire\Summary;

use App\Models\Summary;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Delete extends Component
{
    use Toast;

    public Summary $summary;

    public bool $modal = false;

    #[On('summary::delete')]
    public function confirmAction(int $id): void
    {
        $this->summary = Summary::findOrFail($id);
        $this->modal   = true;
    }

    public function delete(): void
    {
        $this->summary->delete();
        $this->modal = false;
        $this->success(__('O resumo foi excluído.'));
        $this->dispatch('summary::reload')->to('summary.index');
    }

    public function render(): View
    {
        return view('livewire.summary.delete');
    }
}
