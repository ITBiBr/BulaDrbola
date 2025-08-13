<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class CzechDateExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('cesky_datum', [$this, 'formatCzechDate']),
        ];
    }

    public function formatCzechDate(\DateTimeInterface $date): string
    {
        $mesice = [
            1 => 'ledna',
            2 => 'února',
            3 => 'března',
            4 => 'dubna',
            5 => 'května',
            6 => 'června',
            7 => 'července',
            8 => 'srpna',
            9 => 'září',
            10 => 'října',
            11 => 'listopadu',
            12 => 'prosince',
        ];

        $den = $date->format('j');
        $mesic = $mesice[(int) $date->format('n')];
        $rok = $date->format('Y');

        return sprintf('%s. %s %s', $den, $mesic, $rok);
    }
}