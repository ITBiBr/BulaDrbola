<?php

namespace App\Controller;

use App\Entity\Aktuality;
use App\Repository\AktualityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AktualityController extends AbstractController
{
    #[Route('/aktuality', name: 'app_aktuality')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $aktuality = $entityManager->getRepository(Aktuality::class)->findAktualityKZobrazeniPaginated(3,0);

        return $this->render('aktuality/index.html.twig', [
            'controller_name' => 'AktualityController',
            'aktuality' => $aktuality,
            'paticka'=> true,
        ]);
    }

    #[Route('/aktuality/load-more', name: 'aktuality_load_more')]
    public function loadMore(Request $request, AktualityRepository $aktualityRepository): JsonResponse
    {
        $offset = (int) $request->query->get('offset', 0);
        $limit = 3;

        $aktuality = $aktualityRepository->findAktualityKZobrazeniPaginated($limit, $offset);
        $dalsi_aktuality = $aktualityRepository->findAktualityKZobrazeniPaginated($limit, $offset+1);

        // Vrátíme JSON s HTML každé aktuality (nebo pole dat)
        $htmlItems = [];

        foreach ($aktuality as $aktualita) {
            $htmlItems[] = $this->renderView('aktuality/_aktualita.html.twig', [
                'aktualita' => $aktualita,
            ]);
        }

        return new JsonResponse([
            'items' => $htmlItems,
            'nextOffset' => $offset + $limit,
            'hasMore' => count($dalsi_aktuality) >= $limit,
        ]);
    }
}
