<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BlahoreceniController extends AbstractController
{
    #[Route('/blahoreceni', name: 'app_blahoreceni')]
    public function index(): Response
    {
        return $this->render('blahoreceni/index.html.twig', [
            'controller_name' => 'BlahoreceniController',
        ]);
    }
}
