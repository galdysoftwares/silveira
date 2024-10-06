<?php declare(strict_types = 1);

namespace App\Service;

use GuzzleHttp\Client;

class YouTubeApiService
{
    public function __construct(private Client $client)
    {
    }

    public function getVideoDetails(string $videoId): array
    {
        $response = $this->client->get(env('YOUTUBE_API_URL'), [
            'headers' => [
                'x-rapidapi-host' => 'yt-api.p.rapidapi.com',
                'x-rapidapi-key'  => env('YOUTUBE_API_KEY'),
            ],
            'query' => [
                'id' => $videoId,
            ],
        ]);

        dd(json_decode($response->getBody()->getContents(), true));
    }

    public function getId(string $url): string
    {
        return 'video_id';
    }
}
