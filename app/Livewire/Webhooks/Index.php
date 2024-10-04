<?php declare(strict_types = 1);

namespace App\Livewire\Webhooks;

use App\Helpers\Table\Header;
use App\Models\Webhook;
use App\Traits\Livewire\HasTable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Index extends Component
{
    use HasTable;

    public function render(): View
    {
        return view('livewire.webhooks.index');
    }

    public function query(): Builder
    {
        return Webhook::query()
            ->select('*');
    }

    public function searchColumns(): array
    {
        return ['provider'];
    }

    public function tableHeaders(): array
    {
        return [
            Header::make('id', '#'),
            Header::make('provider', __('Provedor')),
            Header::make('payload', __('Payload')),
        ];
    }
}
