<?php

namespace App\Controller;

use App\Entity\Materialy;
use App\Entity\MaterialyKategorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MaterialyController extends AbstractController
{
    #[Route('/materialy', name: 'app_materialy')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        $kategorie = $entityManager->getRepository(MaterialyKategorie::class)->findAll();
        $soubory = $entityManager->getRepository(Materialy::class)->findAll();

        return $this->render('materialy/index.html.twig', [
            'controller_name' => 'MaterialyController',
            'kategorie' => $kategorie,
            'soubory' => $soubory,
            'paticka' => true,
        ]);
    }
}
