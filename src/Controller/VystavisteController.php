<?php

namespace App\Controller;

use App\Entity\Clanky;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class VystavisteController extends ClankyController
{
    #[Route('/vystaviste', name: 'app_vystaviste')]
    public function vystaviste(EntityManagerInterface $entityManager): Response
    {
        // Přesměrování na showAktualita s URL 'vystaviste'
        return $this->showClanek('vystaviste', $entityManager);
    }
}
