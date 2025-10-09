<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VystavisteController extends AbstractController
{
    #[Route('/vystaviste', name: 'app_vystaviste')]
    public function index(): RedirectResponse
    {
        return $this->redirectToRoute('clanky_url', ['url' => 'vystaviste']);
    }
}
