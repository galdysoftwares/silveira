<?php declare(strict_types = 1);

namespace App\Livewire\Summary;

use App\Services\YoutubeApiService;
use Illuminate\View\View;
use Livewire\Component;

class Create extends Component
{
    public string $url = '';

    private YoutubeApiService $youtubeApiService;

    public function boot(YoutubeApiService $youtubeApiService): void
    {
        $this->youtubeApiService = $youtubeApiService;
    }

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

        $videoId       = $this->youtubeApiService->extractVideoID($this->url);
        $videoDetails  = $this->youtubeApiService->getVideoDetails($videoId);
        $videoCaptions = $this->youtubeApiService->getVideoCaptions($videoDetails);

    }

    public function render(): View
    {
        return view('livewire.summary.create');
    }
}
