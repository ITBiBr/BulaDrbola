<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SlavnostBlahoreceniController extends AbstractController
{
    #[Route('/slavnost-blahoreceni', name: 'app_slavnost_blahoreceni')]
    public function index(): Response
    {
        return $this->render('slavnost_blahoreceni/index.html.twig', [

            'paticka' => false
        ]);
    }
}
