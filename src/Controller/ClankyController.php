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

final class ClankyController extends AbstractController
{
    #[Route('/clanky/{url}', name: 'clanky_url')]
    public function showAktualita(string $url, EntityManagerInterface $entityManager): Response
    {
        $clanek = $entityManager->getRepository(Clanky::class)->findOneBy(['url'=>$url]);

        if (!$clanek)
            throw new NotFoundHttpException();
        return $this->render('clanky/clanek.html.twig', [
            'controller_name' => 'ClankyController',
            'clanek' => $clanek,
            'paticka'=> true,
        ]);
    }
}
