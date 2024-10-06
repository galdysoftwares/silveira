<?php declare(strict_types = 1);

namespace App\Services;

use GuzzleHttp\Client;

class OpenRouterApiService
{
    public function __construct(private Client $client)
    {
    }

    // receber conteudo e prompt
    public function generateSummaryFromCaptionsStreaming(array $captions)
    {
        $captionsText = implode(' ', array_column($captions, 'text'));
        $body         = [
            "model"    => "liquid/lfm-40b:free", // Pode ser alterado conforme necessário
            "messages" => [
                [
                    "role"    => "user",
                    "content" => "Aqui estão as legendas extraídas do vídeo. Por favor, gere um resumo com base nelas: " . $captionsText,
                ],
            ],
            "stream" => false,
        ];

        $openRouterApiKey = env('OPEN_ROUTER_KEY');

        try {
            // Cabeçalhos da requisição
            $headers = [
                'Authorization' => "Bearer {$openRouterApiKey}",
                'Content-Type'  => 'application/json',
            ];

            // Fazer a requisição POST para a API do OpenRouter
            $response = $this->client->post('https://openrouter.ai/api/v1/chat/completions', [
                'headers' => $headers,
                'json'    => $body,
                'stream'  => true,
            ]);

            // Pegue o stream da resposta
            $stream = $response->getBody();

            // Variável para armazenar o resumo à medida que chega
            $summary = '';

            // Ler o stream em partes (chunks)
            while (!$stream->eof()) {
                $chunk = $stream->read(1024); // Lê 1KB por vez, por exemplo
                $summary .= $chunk;           // Concatena o conteúdo ao resumo
            }

            return $summary;

        } catch (\Exception $e) {
            // Em caso de erro, logar e retornar null
            error_log("Erro ao gerar resumo: " . $e->getMessage());

            return null;
        }

    }
}
