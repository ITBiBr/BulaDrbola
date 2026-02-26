<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class StrongExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('strong_filter', [$this, 'addFwBold'], ['is_safe' => ['html']]),
        ];
    }

    public function addFwBold(string $text): string
    {
        // Nahradí <strong>...</strong> za <div class="fw-bold">...</div>
        return preg_replace(
            '/<strong>(.*?)<\/strong>/si',
            '<span class="fw-bold">$1</span>',
            $text
        );


    }

}