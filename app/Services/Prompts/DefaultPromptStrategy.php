<?php declare(strict_types = 1);

namespace App\Services\Prompts;

class DefaultPromptStrategy implements PromptStrategyInterface
{
    public function generatePrompt(array $captionsText): string
    {
        $captionsText = implode(' ', $captionsText);

        return "
            Você é um assistente especializado em criar resumos concisos, precisos e bem estruturados.
            Seu objetivo é transformar o seguinte texto em um resumo em formato Markdown:

            $captionsText

            A saída do resumo deve estar em Markdown e seguir esta estrutura:

            - **Título Principal**: Defina o título principal do conteúdo.
            - **Principais Ideias**: Liste os pontos-chave em formato de lista ordenada.
            - **Palavras-chave**: Use **sublinhado** para marcar as palavras-chave essenciais.
            - **Resumo Final**: Escreva um parágrafo resumido.

            ```markdown
            ##Título Principal
            1. Primeira ideia
            2. Segunda ideia
            **Resumo**: O conteúdo aborda os pontos principais...
            ```";
    }
}
