<?php

namespace App\Controller;

use App\Entity\Aktuality;
use App\Entity\Clanky;
use App\Repository\AktualityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ClankyController extends AbstractController
{
    public function __construct(private readonly SluggerInterface $slugger)
    {
    }
    #[Route('/clanky/{url}', name: 'clanky_url')]
    public function showClanek(string $url, EntityManagerInterface $entityManager): Response
    {
        $clanek = $entityManager->getRepository(Clanky::class)->findOneBy(['url'=>$url]);

        if (!$clanek)
            throw new NotFoundHttpException();
        // Přepracování obsahu článku a získání H1 nadpisů
        [$processedContent, $headings] = $this->addHeadingsId($clanek->getObsah());
        dump($processedContent);
        return $this->render('clanky/clanek.html.twig', [
            'controller_name' => 'ClankyController',
            'clanek' => $clanek,
            'obsah' => $processedContent,
            'headings' => $headings,
            'paticka'=> true,
        ]);



    }
    private function addHeadingsId(string $text): array
    {
        $headings = [];

        $processedText = preg_replace_callback('/<h1>([^<]+)<\/h1>/ui', function ($matches) use (&$headings) {
            $heading = trim($matches[1]);
            $id = strtolower($this->slugger->slug($heading));
            $headings[] = ['id' => $id, 'title' => $heading];
            return sprintf('<h5 class="scroll-offset text-primary fw-bold" id="%s">%s</h5>', $id, $heading);
        }, $text);

        return [$processedText, $headings];
    }
}
