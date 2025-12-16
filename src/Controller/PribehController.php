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
        $svgWidth = 919.94092;
        $svgHeight = 514.36469;

        $body= $entityManager->getRepository(BodyMapyPribeh::class)->findAll();

        // Bounding box ČR
        $latMin = 48.551;
        $latMax = 51.057;
        $lonMin = 12.091;
        $lonMax = 18.859;

        $points = [];

        foreach ($body as $bod) {
            // Náhodné souřadnice
            $lat = $bod->getLat();
            $lon = $bod->getLng();

            // Přepočet na SVG souřadnice
            $x = ($lon - $lonMin) / ($lonMax - $lonMin) * $svgWidth;
            $y = $svgHeight - (
                    ($lat - $latMin) / ($latMax - $latMin) * $svgHeight
                );

            $points[] = [
                'id' => $bod->getId(),
                'title' => $bod->getNazev(),
                'description' => $bod->getPopis(),
                'lat' => $lat,
                'lon' => $lon,
                'x' => $x,
                'y' => $y,
            ];
        }


        return $this->render('pribeh/index.html.twig', [
            'controller_name' => 'PribehController',
            'paticka' => false,
            'points' => $points,
            'svgWidth' => $svgWidth,
            'svgHeight' => $svgHeight,
        ]);
    }
}
