<?php declare(strict_types = 1);

namespace App\Services;

use App\Services\Prompts\PromptStrategyInterface;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class LLMService
{
    public function __construct(
        protected Client $client,
        protected PromptStrategyInterface $promptStrategy,
        protected string $model
    ) {
    }

    public function generateSummaryFromCaptions(array $captionsText): array
    {
        $prompt = $this->promptStrategy->generatePrompt($captionsText);

        try {
            $response = $this->client->post(env('OPEN_ROUTER_URL'), [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('OPEN_ROUTER_KEY'),
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    "model"    => $this->model,
                    "messages" => [
                        [
                            "role"    => "user",
                            "content" => $prompt,
                        ],
                    ],
                ],
                'stream' => true,
            ]);

            // Pegue o stream da resposta
            $stream = $response->getBody();

            // Variável para armazenar o resumo à medida que chega
            $summary = '';

            // Ler o stream em partes (chunks)
            while (!$stream->eof()) {
                $chunk = $stream->read(1024);
                $chunk = trim($chunk);
                $summary .= $chunk;
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

    public function getSummary(array $summary): string
    {
        return $summary['choices'][0]['message']['content'];
    }
}
