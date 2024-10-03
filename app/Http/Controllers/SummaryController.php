<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SummaryController extends Controller
{
    public function index()
    {
        $text     = $this->getVideoSubtitles();
        $markdown = implode('', $this->getSummary($text));

        $html = Str::markdown($markdown);

        return view('answer', compact('html'));
    }

    public function getVideoSpeechUrl(): string
    {
        $client        = new Client();
        $youtubeApiUri = 'https://yt-api.p.rapidapi.com/dl';
        $youtubeId     = 'jofdL4xhOIg';

        $response = $client->get($youtubeApiUri, [
            'headers' => [
                'x-rapidapi-host' => 'yt-api.p.rapidapi.com',
                'x-rapidapi-key'  => env('x_rapidapi_key'),
            ],
            'query' => [
                'id' => $youtubeId,
            ],
        ]);

        $data = json_decode($response->getBody(), true);
        dd($data);
        $audioUrl = $data['adaptiveFormats'][14]['url'];

        return $audioUrl;
    }

    public function getVideoSubtitles(): string
    {
        $client        = new Client();
        $youtubeApiUri = 'https://yt-api.p.rapidapi.com/subtitles';
        $youtubeId     = 'jofdL4xhOIg';

        $response = $client->get($youtubeApiUri, [
            'headers' => [
                'x-rapidapi-host' => 'yt-api.p.rapidapi.com',
                'x-rapidapi-key'  => env('x_rapidapi_key'),
            ],
            'query' => [
                'id' => $youtubeId,
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        $url = $data['subtitles'][0]['url'];

        return $this->getContent($url);
    }

    public function getContent(string $url)
    {
        // Fazer a requisição para a URL
        $response = Http::get($url);

        // Verificar se a requisição foi bem-sucedida
        if ($response->successful()) {
            // Pegar o conteúdo XML
            $xmlContent = $response->body();

            // Converter XML para um objeto
            $xml = simplexml_load_string($xmlContent);
            // Opcional: Converter para JSON ou Array
            $json  = json_encode($xml);
            $array = json_decode($json, true);

            // Retornar o array ou realizar outra operação com os dados
            return implode(' ', $array['text']);
            // Ou exibir como JSON: return response()->json($array);
        } else {
            // Lidar com erro
            return response()->json(['error' => 'Unable to fetch data'], 500);
        }
    }

    public function getSummary(string $text)
    {
        $PROJECT_ID        = env('PROJECT_ID');
        $GOOGLE_AUTH_TOKEN = env('GOOGLE_AUTH_TOKEN');

        $uri = "https://us-central1-aiplatform.googleapis.com/v1/projects/$PROJECT_ID/locations/us-central1/publishers/google/models/gemini-1.0-pro:streamGenerateContent";

        $client   = new Client();
        $response = $client->post($uri, [
            'headers' => [
                "Authorization" => "Bearer $GOOGLE_AUTH_TOKEN",
                "Content-Type"  => "application/json",
            ],
            'json' => [
                'contents' => [
                    [
                        'role'  => 'user',
                        'parts' => [
                            [
                                'text' => "$text",
                            ],
                        ],
                    ],
                ],
            ],
        ]);

        $contents = json_decode($response->getBody(), true);

        $answer = [];

        foreach ($contents as $content) {
            $answer[] = $content['candidates'][0]['content']['parts'][0]['text'];
        }

        return $answer;
    }
}
