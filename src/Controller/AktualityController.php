<?php

namespace App\Controller;

use App\Entity\Aktuality;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AktualityController extends AbstractController
{
    #[Route('/aktuality', name: 'app_aktuality')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $aktuality = $entityManager->getRepository(Aktuality::class)->findAktualityKZobrazeni();

        return $this->render('aktuality/index.html.twig', [
            'controller_name' => 'AktualityController',
            'aktuality' => $aktuality,
            'paticka'=> true,
        ]);
    }
}
