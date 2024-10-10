<?php declare(strict_types = 1);

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class OpenRouterApiService
{
    public function __construct(private Client $client)
    {
    }

    public function generateSummaryFromCaptionsStreaming(array $captions): array
    {
        $captionsText = implode(' ', array_column($captions, 'text'));
        $prompt       = [
            'default' => "Você é um assistente especializado em criar resumos concisos, precisos e bem estruturados. Seu objetivo é transformar o seguinte texto em um resumo em formato Markdown, focando nas seguintes diretrizes:

                1. **Destacar as principais ideias**: Identifique e marque os pontos mais relevantes do texto.
                2. **Sublinhar palavras-chave**: Use sublinhado para realçar as palavras mais importantes e termos essenciais.
                3. **Poder de síntese**: Resuma de forma clara e direta, eliminando informações redundantes.
                4. **Coesão e coerência**: Assegure que o resumo seja fluido e organizado, mantendo uma boa conexão entre as ideias.

                Aqui está o conteúdo a ser resumido:

                $captionsText

                A saída do resumo deve estar em **Markdown** e seguir essa estrutura:

                - **Título Principal**: Defina o título principal do conteúdo.
                - **Principais Ideias**: Liste os pontos-chave em formato de lista ordenada ou com bullet points.
                - **Palavras-chave**: Use **sublinhado** para marcar as palavras-chave essenciais.
                - **Resumo Final**: Escreva um parágrafo resumindo o conteúdo, mantendo a coesão e coerência.

                Exemplo de formatação esperada:

                ```markdown
                ##Título Principal

                1. Primeira ideia principal.
                2. Segunda ideia relevante.
                3. Terceiro ponto chave.

                **Resumo**:
                O texto aborda _palavra-chave 1_, _palavra-chave 2_, e _palavra-chave 3_. Ele destaca que...
            ",
        ];

        $body = [
            "model"    => "liquid/lfm-40b:free", // Pode ser alterado conforme necessário
            "messages" => [
                [
                    "role"    => "user",
                    "content" => $prompt['default'],
                ],
            ],
            "stream" => false,
        ];

        $openRouterApiKey = env('OPEN_ROUTER_KEY');

        try {
            $headers = [
                'Authorization' => "Bearer {$openRouterApiKey}",
                'Content-Type'  => 'application/json',
            ];

            $response = $this->client->post(env('OPEN_ROUTER_URL'), [
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
                $chunk = $stream->read(1024);   // Lê 1KB por vez, por exemplo
                $chunk = trim($chunk);          // Limpar resposta
                $summary .= $chunk;             // Concatena o conteúdo ao resumo
            }

            // Converte o resumo final para um array JSON (decodificação JSON)
            $decodedSummary = json_decode($summary, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                return $decodedSummary;
            } else {
                throw new \Exception("Erro ao decodificar JSON: " . json_last_error_msg());
            }

        } catch (\Exception $e) {
            Log::info("Erro ao gerar resumo: " . $e->getMessage());

            return null;
        }

    }

    public function getMessageContent(array $openRouterResponseDto): string
    {
        return $openRouterResponseDto['choices'][0]['message']['content'];
    }

}
