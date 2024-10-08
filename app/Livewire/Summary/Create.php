<?php declare(strict_types = 1);

namespace App\Livewire\Summary;

use App\Models\{Summary, Video};
use App\Services\{SummaryService, VideoService};
use Illuminate\View\View;
use Livewire\Component;

class Create extends Component
{
    public string $url = '';

    public string $summary = '';

    protected VideoService $videoService;

    protected SummaryService $summaryService;

    public function boot(
        VideoService $videoService,
        SummaryService $summaryService
    ): void {
        $this->videoService   = $videoService;
        $this->summaryService = $summaryService;
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
        $this->validate(); // Validação isolada

        // Obtém as informações do vídeo
        $videoInfo = $this->videoService->getVideoInfo($this->url);

        // Captions
        $captions = $this->videoService->getVideoCaptions($videoInfo['captionsUrl']);

        // Gera o resumo
        $summaryContent = $this->summaryService->generateSummary($captions);

        // Persistência no banco de dados
        $video = Video::create([
            'url'         => $this->url,
            'youtube_id'  => $videoInfo['id'],
            'title'       => $videoInfo['title'],
            'description' => $videoInfo['description'],
            'captions'    => json_encode($captions),
        ]);

        $summary = Summary::create([
            'title'    => $videoInfo['title'],
            'content'  => $summaryContent,
            'user_id'  => auth()->id(),
            'video_id' => $video->id,
        ]);

        // Redireciona após a conclusão
        $this->redirectRoute('summaries.show', ['summary' => $summary]);
    }

    public function render(): View
    {
        return view('livewire.summary.create');
    }
}
