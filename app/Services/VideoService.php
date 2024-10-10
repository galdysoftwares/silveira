<?php declare(strict_types = 1);

namespace App\Services;

class VideoService
{
    public function __construct(
        protected RapidYoutubeApiService $youtubeApiService
    ) {
    }

    public function getVideoInfo(string $url): array
    {
        $videoId      = $this->youtubeApiService->extractVideoID($url);
        $videoDetails = $this->youtubeApiService->getVideoDetails($videoId);

        return [
            'id'          => $videoId,
            'title'       => $this->youtubeApiService->getVideoTitle($videoDetails),
            'description' => $this->youtubeApiService->getVideodescription($videoDetails),
            'captionsUrl' => $this->youtubeApiService->getVideoCaptionsUrl($videoDetails),
        ];
    }

    public function getVideoCaptions(string $captionsUrl): array
    {
        return $this->youtubeApiService->getVideoCaptions($captionsUrl);
    }
}
