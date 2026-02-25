<?php

namespace App\Controller;

use App\Entity\Aktuality;
use App\Repository\AktualityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class AktualityController extends AbstractController
{
    #[Route('/aktuality', name: 'app_aktuality')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $limit = 9;
        $aktuality = $entityManager->getRepository(Aktuality::class)->findAktualityKZobrazeniPaginated($limit+1,0);
        $hasMore = count($aktuality) > $limit;
        $aktuality = array_slice($aktuality, 0, $limit);

        return $this->render('aktuality/index.html.twig', [
            'controller_name' => 'AktualityController',
            'limit' => $limit,
            'aktuality' => $aktuality,
            'hasMore' => $hasMore,
            'paticka'=> true,
        ]);
    }

    #[Route('/aktuality/load-more', name: 'aktuality_load_more')]
    public function loadMore(Request $request, AktualityRepository $aktualityRepository): JsonResponse
    {
        $offset = (int) $request->query->get('offset', 0);
        $limit = 9;

        $aktuality = $aktualityRepository->findAktualityKZobrazeniPaginated($limit+1, $offset);
        $hasMore = count($aktuality) > $limit;
        $aktuality = array_slice($aktuality, 0, $limit);

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
            'hasMore' => $hasMore,
        ]);
    }
    #[Route('/aktuality/{url}', name: 'aktuality_url')]
    public function showAktualita(string $url, EntityManagerInterface $entityManager): Response
    {
        $aktualita = $entityManager->getRepository(Aktuality::class)->findOneBy(['url'=>$url]);

        if (!$aktualita)
            throw new NotFoundHttpException();
        return $this->render('aktuality/aktualita.html.twig', [
            'controller_name' => 'AktualityController',
            'aktualita' => $aktualita,
            'paticka'=> true,
        ]);
    }
}
