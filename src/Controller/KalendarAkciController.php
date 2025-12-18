<?php

namespace App\Controller;

use App\Entity\Akce;
use App\Entity\Aktuality;
use App\Repository\AkceRepository;
use App\Repository\AktualityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class KalendarAkciController extends AbstractController
{
    #[Route('/kalendar-akci', name: 'app_kalendar_akci')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $limit = 12;
        $akce = $entityManager->getRepository(Akce::class)->findAkceKZobrazeniPaginated($limit,0);

        return $this->render('kalendar_akci/index.html.twig', [
            'controller_name' => 'KalendarAkciController',
            'limit' => $limit,
            'akce' => $akce,
            'paticka'=> true,
        ]);
    }

    #[Route('/akce/{url}', name: 'akce_url')]
    public function showAkce(string $url, EntityManagerInterface $entityManager): Response
    {
        $akce = $entityManager->getRepository(Akce::class)->findOneBy(['url'=>$url]);

        if (!$akce)
            throw new NotFoundHttpException();
        return $this->render('kalendar_akci/akce.html.twig', [
            'controller_name' => 'AkceController',
            'aktualita' => $akce,
            'paticka'=> true,
        ]);
    }

    #[Route('/kalendar-akci/load-more', name: 'akce_load_more')]
    public function loadMore(Request $request, AkceRepository $akceRepository): JsonResponse
    {
        $offset = (int) $request->query->get('offset', 0);
        $limit = 6;

        $akce = $akceRepository->findAkceKZobrazeniPaginated($limit, $offset);
        $dalsi_akce= $akceRepository->findAkceKZobrazeniPaginated($limit, $offset+1);

        // Vrátíme JSON s HTML každé aktuality (nebo pole dat)
        $htmlItems = [];

        foreach ($akce as $ak) {
            $htmlItems[] = $this->renderView('kalendar_akci/_akce.html.twig', [
                'akce' => $ak,
            ]);

            $akceData[] = [
                'id' => $ak->getId(),
                'titulek' => $ak->getTitulek(),
                'perex' => $ak->getPerex(),
                'lat' => $ak->getLat(),
                'lng' => $ak->getLng(),
            ];
        }

        return new JsonResponse([
            'items' => $htmlItems,
            'nextOffset' => $offset + $limit,
            'hasMore' => count($dalsi_akce) >= $limit,
            'akce' => $akceData,
        ]);
    }
}
