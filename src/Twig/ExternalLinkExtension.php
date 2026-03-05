<?php

namespace App\Twig;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ExternalLinkExtension extends AbstractExtension
{
    private string $webUrl;

    public function __construct(ParameterBagInterface $params)
    {
        $webUrl = $params->get('web_url');

        // odstraníme protokol i www
        $clean = preg_replace('#^https?://#', '', rtrim($webUrl, '/'));
        $clean = preg_replace('#^www\.#', '', $clean);

        $this->webUrl = $clean;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('external_links', [$this, 'processLinks'], ['is_safe' => ['html']]),
        ];
    }

    public function processLinks(string $html): string
    {
        return preg_replace_callback(
            '/<a\s+([^>]*href=["\']([^"\']+)["\'][^>]*)>/i',
            function ($matches) {
                $fullTag = $matches[1];
                $href = $matches[2];

                // 1) RELATIVNÍ URL → interní, nic neměníme
                if (!preg_match('#^https?://#i', $href)) {
                    return "<a {$fullTag}>";
                }

                // 2) ABSOLUTNÍ URL → odstraníme protokol i www
                $cleanHref = preg_replace('#^https?://#', '', $href);
                $cleanHref = preg_replace('#^www\.#', '', $cleanHref);

                // 3) Pokud začíná na doménu → interní absolutní → přepíšeme na relativní
                if (str_starts_with($cleanHref, $this->webUrl)) {

                    // odstraníme doménu
                    $relative = substr($cleanHref, strlen($this->webUrl));

                    // odstraníme případné počáteční /
                    $relative = ltrim($relative, '/');

                    // přepíšeme href="..."
                    $newTag = preg_replace(
                        '/href=["\'][^"\']+["\']/',
                        'href="' . $relative . '"',
                        $fullTag
                    );

                    return "<a {$newTag}>";
                }

                // 4) Externí URL → přidáme target="_blank" (pokud tam není)
                if (!preg_match('/target=["\'].*?["\']/', $fullTag)) {
                    $fullTag .= ' target="_blank"';
                }

                return "<a {$fullTag}>";
            },
            $html
        );
    }
}