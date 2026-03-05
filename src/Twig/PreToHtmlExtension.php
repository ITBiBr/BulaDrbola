<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PreToHtmlExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('pre_to_html', [$this, 'convert'], ['is_safe' => ['html']]),
        ];
    }

    public function convert(string $text): string
    {
        return preg_replace_callback(
            '/<pre>(.*?)<\/pre>/si',
            function ($matches) {
                return html_entity_decode($matches[1], ENT_QUOTES | ENT_HTML5);
            },
            $text
        );
    }
}