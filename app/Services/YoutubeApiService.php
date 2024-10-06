<?php declare(strict_types = 1);

namespace App\Services;

use GuzzleHttp\Client;
use SimpleXMLElement;

class YoutubeApiService
{
    public function __construct(private Client $client)
    {
    }

    public function getVideoDetails(string $videoId): array
    {
        $response = $this->client->get(env('YOUTUBE_RAPID_API_URL'), [
            'headers' => [
                'x-rapidapi-host' => 'yt-api.p.rapidapi.com',
                'x-rapidapi-key'  => env('YOUTUBE_RAPID_API_KEY'),
            ],
            'query' => [
                'id' => $videoId,
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    public function extractVideoID(string $url): ?string
    {
        // Expressão regular para identificar URLs do YouTube
        $pattern = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:watch\?v=|embed\/|v\/|.+\?v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';

        // Verifica se a URL corresponde ao padrão e captura o ID do vídeo
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1]; // Retorna o ID do vídeo
        }

        // Retorna null se não for uma URL válida do YouTube
        return null;
    }

    public function getVideoCaptions(array $videoDetails): array
    {
        $url = $videoDetails['captions']['captionTracks'][0]['baseUrl'];

        try {
            $response   = $this->client->get($url);
            $xmlContent = $response->getBody()->getContents();

            $xml = new SimpleXMLElement($xmlContent);

            foreach ($xml->text as $caption) {
                $start    = floatval($caption['start']);
                $duration = isset($caption['dur']) ? floatval($caption['dur']) : 0;
                $end      = $start + $duration;
                $text     = trim((string) $caption);

                $captions[] = [
                    'start' => $start,      // Tempo de início em segundos
                    'end'   => $end,        // Tempo de fim em segundos
                    'text'  => $text,       // Texto da legenda
                ];
            }

            return $captions;
        } catch (\Exception $e) {
            throw new \RuntimeException("Error fetching or parsing captions: " . $e->getMessage());
        }
    }
}
