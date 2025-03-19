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
        $lorem = $this->generateLoremIpsum(50);
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'lorem' => $lorem,
        ]);
    }

    private function generateLoremIpsum(int $lines): string
    {
        $lorem = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum.";
        $text = '';

        for ($i = 0; $i < $lines; $i++) {
            $text .= $lorem . "<br>";
        }

        return $text;
    }
}
