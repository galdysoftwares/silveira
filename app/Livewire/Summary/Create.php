<?php declare(strict_types = 1);

namespace App\Livewire\Summary;

use Illuminate\View\View;
use Livewire\Component;

class Create extends Component
{
    public string $url = '';

    public function rules(): array
    {
        return [
            'url' => ['required', 'regex:/^(https?\:\/\/)?(www\.youtube\.com|youtu\.?be)\/.+$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'url.required' => 'O campo URL é obrigatório.',
            'url.regex'    => 'A URL fornecida deve ser um link válido do YouTube.',
        ];
    }

    public function generateResume()
    {
        $this->validate();

    }

    public function render(): View
    {
        return view('livewire.summary.create');
    }
}
