<?php declare(strict_types = 1);

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Component;

class Quill extends Component
{
    public string $quillId;

    public ?string $value = null;

    public string $component;

    public function updatedValue(): void
    {
        $this->dispatch("{$this->quillId}::updated", $this->value)->to($this->component);
    }

    public function render(): View
    {
        return view('livewire.quill');
    }
}
