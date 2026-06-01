<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PrepisController extends AbstractController
{
    #[Route('/prepis', name: 'app_prepis')]
    public function index(): RedirectResponse
    {
        return $this->redirect('https://text-on-tap.live/#e=slavnost-blahoreceni');
    }
}
