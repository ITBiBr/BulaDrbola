<?php

namespace App\Controller;

use App\Entity\SlavnostBlahoreceniKategorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SlavnostBlahoreceniController extends AbstractController
{
    #[Route('/slavnost-blahoreceni', name: 'app_slavnost_blahoreceni')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $kategorieTextu = $entityManager->getRepository(SlavnostBlahoreceniKategorie::class)->findAll();
        return $this->render('slavnost_blahoreceni/index.html.twig', [
            'kategorieTextu' => $kategorieTextu,
            'paticka' => false,
        ]);
    }
}
