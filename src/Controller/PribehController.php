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
        return $this->render('pribeh/index.html.twig', [
            'controller_name' => 'PribehController',
        ]);
    }
}
