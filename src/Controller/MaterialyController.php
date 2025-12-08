<?php

namespace App\Controller;

use App\Entity\Materialy;
use App\Entity\MaterialyKategorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

final class MaterialyController extends AbstractController
{
    #[Route('/materialy', name: 'app_materialy')]
    public function index(EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {

        $soubory = $entityManager->getRepository(Materialy::class)->findBy([], ['Nazev' => 'ASC']);


        return $this->render('materialy/index.html.twig', [
            'controller_name' => 'MaterialyController',
            'soubory' => $soubory,
            'paticka' => true,
        ]);
    }
}
