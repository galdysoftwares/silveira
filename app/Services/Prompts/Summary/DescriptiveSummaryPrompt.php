<?php declare(strict_types = 1);

namespace App\Services\Prompts\Summary;

use App\Services\Prompts\PromptStrategyInterface;

class DescriptiveSummaryPrompt implements PromptStrategyInterface
{
    public function generatePrompt(array $captionsText): string
    {
        $text = implode(' ', array_column($captionsText, 'text'));

        return "
            Você é um assistente brasileiro que só fala portugues do brasil, especializado em gerar resumos descritivos que oferecem uma visão geral clara e precisa de um trabalho ou documento.
            Siga as seguintes diretrizes para criar o resumo:

            1. Visão Geral do Trabalho: O resumo deve começar com uma frase significativa que introduza o tema principal ao leitor.
            2. Pontos-Chave: O texto deve apresentar os pontos mais importantes e relevantes do trabalho.
            3. Método de Investigação: Se aplicável, inclua uma descrição concisa do método utilizado no trabalho.
            4. Texto Corrido: O resumo deve ser composto por frases concisas, afirmativas e simples, formando um texto coeso e fluido.
            5. Coerência: Assegure que as frases estejam bem conectadas, fornecendo uma narrativa clara e fácil de seguir.

            Aqui está o conteúdo que precisa ser resumido:

            $text

            Estrutura esperada:

            - O resumo deve ser um texto corrido e não pode ser separado em tópicos.
            - A primeira frase deve introduzir o documento, e as frases seguintes devem apresentar os pontos-chave e o método.
            - O texto deve ser curto, objetivo e informativo, mantendo a coesão e a coerência do início ao fim.

            A saída do resumo deve estar em **Markdown** e deve ter uma assinatura no final/rodape com o seguinte dizer:
            resumo do tipo descritivo gerado pela mytho free llm
            ";
    }
}
