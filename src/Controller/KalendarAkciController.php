<?php

namespace App\Controller;

use App\Entity\Akce;
use App\Entity\Aktuality;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class KalendarAkciController extends AbstractController
{
    #[Route('/kalendar/akci', name: 'app_kalendar_akci')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $akce = $entityManager->getRepository(Akce::class)->findAkceKZobrazeniPaginated(9,0);

        return $this->render('kalendar_akci/index.html.twig', [
            'controller_name' => 'KalendarAkciController',
            'akce' => $akce,
            'paticka'=> true,
        ]);
    }

    #[Route('/akce/{url}', name: 'akce_url')]
    public function showAktualita(string $url, EntityManagerInterface $entityManager): Response
    {
        $akce = $entityManager->getRepository(Akce::class)->findOneBy(['url'=>$url]);

        if (!$akce)
            throw new NotFoundHttpException();
        return $this->render('kalendar_akci/akce.html.twig', [
            'controller_name' => 'AktualityController',
            'aktualita' => $akce,
            'paticka'=> true,
        ]);
    }
}
