<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MaterialyController extends AbstractController
{
    #[Route('/materialy', name: 'app_materialy')]
    public function index(): Response
    {
        return $this->render('materialy/index.html.twig', [
            'controller_name' => 'MaterialyController',
            'paticka' => true,
        ]);
    }
}
