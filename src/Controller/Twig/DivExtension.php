<?php

namespace App\Controller\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class DivExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('div_filter', [$this, 'addDivFilter'], ['is_safe' => ['html']]),
        ];
    }

    public function addDivFilter(string $text): string
    {
        return preg_replace(
            '/<div([^>]*)>((?:(?!<\/div>).)*?)<br\s*\/?>\s*<br\s*\/?>\s*<\/div>/si',
            '<div$1 class="pb-3">$2</div>',
            $text
        );

    }

}