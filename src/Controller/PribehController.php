<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PribehController extends AbstractController
{
    #[Route('/pribeh', name: 'app_pribeh')]
    public function index(): Response
    {

        // Rozměry SVG (musí odpovídat viewBox)
        $svgWidth = 919.94092;
        $svgHeight = 514.36469;

        // Bounding box ČR
        $latMin = 48.55;
        $latMax = 51.06;
        $lonMin = 12.09;
        $lonMax = 18.87;

        $points = [];

        for ($i = 0; $i < 5; $i++) {
            // Náhodné souřadnice
            $lat = $latMin + mt_rand() / mt_getrandmax() * ($latMax - $latMin);
            $lon = $lonMin + mt_rand() / mt_getrandmax() * ($lonMax - $lonMin);

            // Přepočet na SVG souřadnice
            $x = ($lon - $lonMin) / ($lonMax - $lonMin) * $svgWidth;
            $y = $svgHeight - (
                    ($lat - $latMin) / ($latMax - $latMin) * $svgHeight
                );

            $points[] = [
                'id' => $i,
                'title' => "Místo #$i",
                'description' => "Popis bodu číslo $i",
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
