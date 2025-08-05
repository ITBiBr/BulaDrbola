<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AktualityController extends AbstractController
{
    #[Route('/aktuality', name: 'app_aktuality')]
    public function index(): Response
    {
        return $this->render('aktuality/index.html.twig', [
            'controller_name' => 'AktualityController',
        ]);
    }
}
