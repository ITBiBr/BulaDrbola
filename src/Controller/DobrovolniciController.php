<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DobrovolniciController extends AbstractController
{
    #[Route('/dobrovolnici', name: 'app_dobrovolnici')]
    public function index(): Response
    {
        return $this->render('dobrovolnici/index.html.twig', [
            'controller_name' => 'DobrovolniciController',
            'paticka'=> true,
        ]);
    }
}
