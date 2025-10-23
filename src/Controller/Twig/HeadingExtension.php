<?php

namespace App\Controller\Twig;

use Symfony\Component\String\Slugger\SluggerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class HeadingExtension extends AbstractExtension
{

    public function __construct(private readonly SluggerInterface $slugger)
    {

    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('headings_id', [$this, 'addHeadingsId'], ['is_safe' => ['html']]),
        ];
    }
    public function addHeadingsId(string $text): string
    {
        $slugger = $this->slugger;
        return preg_replace_callback('/<h1>([^<]+)<\/h1>/ui', function ($matches) use ($slugger) {
            $heading = trim($matches[1]);
            // vytvoří slug, převede na malá písmena
            $id = strtolower($slugger->slug($heading));
            return sprintf('<h5 class="text-primary fw-bold" id="%s">%s</h5>', $id, $heading);
        }, $text);
    }
}