<?php declare(strict_types = 1);

namespace App\Livewire\Summary;

use App\Models\{Summary, Video};
use App\Services\{OpenRouterApiService, YoutubeApiService};
use Illuminate\View\View;
use Livewire\Component;
use Parsedown;

class Create extends Component
{
    public string $url = '';

    public string $summary = '';

    private YoutubeApiService $youtubeApiService;

    private OpenRouterApiService $openRouterApiService;

    public function boot(
        YoutubeApiService $youtubeApiService,
        OpenRouterApiService $openRouterApiService
    ): void {
        $this->youtubeApiService    = $youtubeApiService;
        $this->openRouterApiService = $openRouterApiService;
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

    public function mount()
    {
        $parsedown = new Parsedown();

        $this->summary = $parsedown->text(Summary::first()->content);
    }

    public function generateResume()
    {
        $this->validate();

        $videoId          = $this->youtubeApiService->extractVideoID($this->url);
        $videoDetails     = $this->youtubeApiService->getVideoDetails($videoId);
        $captionsUrl      = $this->youtubeApiService->getVideoCaptionsUrl($videoDetails);
        $videoCaptions    = $this->youtubeApiService->getVideoCaptions($captionsUrl);
        $summary          = $this->openRouterApiService->generateSummaryFromCaptionsStreaming($videoCaptions);
        $videoTitle       = $this->youtubeApiService->getVideoTitle($videoDetails);
        $videoDescription = $this->youtubeApiService->getVideodescription($videoDetails);

        $video = Video::create([
            'url'         => $this->url,
            'youtube_id'  => $videoId,
            'title'       => $videoTitle,
            'description' => $videoDescription,
            'captions'    => json_encode($videoCaptions),
        ]);

        $this->summary = $this->openRouterApiService->getMessageContent($summary);

        Summary::create([
            'title'    => $videoTitle,
            'content'  => $this->summary,
            'user_id'  => auth()->id(),
            'video_id' => $video->id,
        ]);

        $parsedown = new Parsedown();

        $this->summary = $parsedown->text($this->summary);
    }

    public function render(): View
    {
        return view('livewire.summary.create');
    }
}
