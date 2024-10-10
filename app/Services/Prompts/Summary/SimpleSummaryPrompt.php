<?php declare(strict_types = 1);

namespace App\Services\Prompts\Summary;

use App\Services\Prompts\PromptStrategyInterface;

class SimpleSummaryPrompt implements PromptStrategyInterface
{
    public function generatePrompt(array $captionsText): string
    {
        $text = implode(' ', array_column($captionsText, 'text'));

        return "
            Você é um assistente especializado em gerar **resumos simples**, frequentemente utilizados em artigos científicos, TCCs, congressos, seminários e eventos acadêmicos.
            Siga as diretrizes abaixo para criar um resumo claro e objetivo:

            1. **Apresente o tema principal**: A primeira frase deve introduzir claramente o tema ou o problema que o trabalho aborda.
            2. **Objetivo**: Descreva o objetivo principal do trabalho ou estudo de forma direta.
            3. **Metodologia**: Se aplicável, descreva de forma concisa o método utilizado no estudo ou a abordagem seguida para realizar a pesquisa.
            4. **Resultados**: Resuma os principais resultados ou descobertas do trabalho.
            5. **Conclusão**: Finalize com uma frase que apresente a conclusão ou contribuição final do estudo.

            O resumo deve ser:
            - **Conciso e direto**, com frases claras e afirmativas.
            - **Texto corrido** com boa coesão e coerência.
            - Deve **fornecer uma visão geral do trabalho** em poucas palavras.

            Aqui está o conteúdo a ser resumido:

            $text

            A estrutura esperada é a seguinte:

            1. **Introdução ao tema**.
            2. **Objetivo do trabalho**.
            3. **Metodologia utilizada**.
            4. **Principais resultados**.
            5. **Conclusão final**.

            O texto deve ser simples, informativo e ideal para a apresentação de trabalhos em eventos acadêmicos ou científicos.


            A saída do resumo deve estar em Markdown.";
    }
}
