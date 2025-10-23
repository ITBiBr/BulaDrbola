<?php

namespace App\Controller\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class NbspExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('nbsp_prepositions', [$this, 'addNbsp'], ['is_safe' => ['html']]),
        ];
    }

    public function addNbsp(string $text): string
    {
        // 1) Jednopísmenné předložky a spojky (a, i, k, s, v, z, o, u)
        // 2) Zkratka "P." (např. P. Novák)
        $patterns = [
            // jednopísmenné spojky/předložky
            '/(?<=\s|^)([KkSsVvZzOoUuAaIi])\s+(?=\S)/u',
            // zkratka P.
            '/(?<=\bP\.)\s+(?=\p{Lu})/u',  // mezi "P." a velkým písmenem
        ];

        $replacements = [
            '$1&nbsp;',
            '&nbsp;',
        ];
        return preg_replace($patterns, $replacements, $text);
    }
}