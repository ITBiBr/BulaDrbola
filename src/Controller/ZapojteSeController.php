<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ZapojteSeController extends AbstractController
{
    #[Route('/zapojte-se', name: 'app_zapojte_se')]
    public function index(): Response
    {
        return $this->render('zapojte_se/index.html.twig', [
            'controller_name' => 'ZapojteSeController',
        ]);
    }
}
