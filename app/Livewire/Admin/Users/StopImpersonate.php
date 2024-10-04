<?php declare(strict_types = 1);

namespace App\Livewire\Admin\Users;

use Livewire\Component;

class StopImpersonate extends Component
{
    public function render()
    {
        return <<<'BLADE'
        <div wire:click="stop">
            <span class="absolute top-0 right-0 z-50 p-2 mr-2 text-xs font-bold text-white bg-red-500 rounded-full cursor-pointer">
                Impersonating {{ auth()->user()->name }}, click here to stop.
            </span>
        </div>
        BLADE;
    }

    public function stop()
    {
        session()->forget('impersonate');

        return redirect()->route('admin.dashboard');
    }
}
