<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'paticka' => false,
        ]);
    }

    #[Route('/en', name: 'app_main_en')]
    public function ciziIndex(): Response
    {
        return $this->render('main/index_cizojazycny.html.twig', [
            'paticka' => false,
            'cizi_jazyk' => 'en'
        ]);
    }
}
