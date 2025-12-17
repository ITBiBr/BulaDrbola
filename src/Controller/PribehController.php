<?php

namespace App\Controller;

use App\Entity\BodyMapyPribeh;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PribehController extends AbstractController
{
    #[Route('/pribeh', name: 'app_pribeh')]
    public function index(EntityManagerInterface $entityManager): Response
    {

        // Rozměry SVG (musí odpovídat viewBox)
        $svgWidth = 375.18805;
        $svgHeight = 256.465;

        $body= $entityManager->getRepository(BodyMapyPribeh::class)->findAll();

        // Bounding box ČR
        $latMin = 48.615;
        $latMax = 49.864;
        $lonMin = 14.870;
        $lonMax = 17.657;


        foreach ($body as $bod) {
            // Náhodné souřadnice
            $lat = $bod->getLat();
            $lon = $bod->getLng();

            // Přepočet na SVG souřadnice
            $bod->setX(($lon - $lonMin) / ($lonMax - $lonMin) * $svgWidth);
            $bod->setY($svgHeight - (
                    ($lat - $latMin) / ($latMax - $latMin) * $svgHeight
                ));

        }


        return $this->render('pribeh/index.html.twig', [
            'controller_name' => 'PribehController',
            'paticka' => false,
            'points' => $body,
            'svgWidth' => $svgWidth,
            'svgHeight' => $svgHeight,
        ]);
    }
}
