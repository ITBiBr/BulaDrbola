<?php

namespace App\Controller;

use App\Entity\Akce;
use App\Entity\Stitky;
use App\Repository\AkceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class KalendarAkciController extends AbstractController
{

    public function __construct(
        private readonly CacheManager $cacheManager,
    ) {}
    #[Route('/kalendar-akci/{stitek?}', name: 'app_kalendar_akci')]
    #[Route('/mame-za-sebou/{stitek?}', name: 'app_mame_za_sebou')]
    public function index(EntityManagerInterface $entityManager, Request $request, ?string $stitek = null): Response
    {
        $limit = 8;
        $jeProbehle = $request->attributes
                ->get('_route') === 'app_mame_za_sebou';

        $stitkyRepo = $entityManager->getRepository(Stitky::class);
        $akceRepo = $entityManager->getRepository(Akce::class);
        $stitky = $stitkyRepo->findStitkySPlatnymiAkcemi($jeProbehle);
        $aktivniStitek = $stitek ? $stitkyRepo->findOneBy(['url' => $stitek]) : null;

        $akce = $akceRepo->findAkceKZobrazeniPaginated($limit + 1,0,$aktivniStitek, $jeProbehle);
        $hasMore = count($akce) > $limit;
        $akce = array_slice($akce, 0, $limit);

        return $this->render('kalendar_akci/index.html.twig', [
            'controller_name' => 'KalendarAkciController',
            'limit' => $limit,
            'akce' => $akce,
            'paticka'=> true,
            'stitky' => $stitky,
            'hasMore' => $hasMore,
            'aktivniStitek' => $aktivniStitek,
            'probehle' => $jeProbehle
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

    #[Route('/nacist-dalsi-akce/{stitek?}', name: 'akce_load_more')]
    public function loadMore(Request $request, EntityManagerInterface $entityManager, ?string $stitek = null): JsonResponse
    {
        $offset = (int) $request->query->get('offset', 0);
        $limit = 8;
        $stitkyRepo = $entityManager->getRepository(Stitky::class);
        $akceRepo = $entityManager->getRepository(Akce::class);
        $aktivniStitek = $stitek ? $stitkyRepo->findOneBy(['url' => $stitek]) : null;
        $akce = $akceRepo->findAkceKZobrazeniPaginated($limit + 1, $offset, $aktivniStitek);
        $hasMore = count($akce) > $limit;
        $akce = array_slice($akce, 0, $limit);

        // Vrátíme JSON s HTML každé aktuality (nebo pole dat)
        $htmlItems = [];

        foreach ($akce as $ak) {
            $htmlItems[] = $this->renderView('kalendar_akci/_akce.html.twig', [
                'akce' => $ak,
            ]);
            $akceData[] = [
                'id' => $ak->getId(),
                'titulek' => $ak->getTitulek(),
                'obsah' => $ak->getObsah(),
                'img' => $this->cacheManager->getBrowserPath('images/aktuality/' . $ak->getObrazek(),'akce_thumb'),
                'url' => 'akce/'.$ak->getUrl(),
                'lat' => $ak->getLat(),
                'lng' => $ak->getLng(),
            ];
        }

        return new JsonResponse([
            'items' => $htmlItems,
            'nextOffset' => $offset + $limit,
            'hasMore' => $hasMore,
            'akce' => $akceData,
        ]);
    }
}
