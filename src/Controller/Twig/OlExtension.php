<?php

namespace App\Controller\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class OlExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('ol_filter', [$this, 'addOl'], ['is_safe' => ['html']]),
        ];
    }

    public function addOl(string $text): string
    {

        return preg_replace(
            '/<ol>(.*?)<\/ol>/si',
            '<ol class="text-justify-left ps-3">$1</ol>',
            $text
        );


    }

}