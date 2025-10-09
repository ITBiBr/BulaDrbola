<?php

namespace App\Controller;

use App\Entity\Clanky;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class VystavisteController extends AbstractController
{
    #[Route('/vystaviste', name: 'app_vystaviste')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $clanek = $entityManager->getRepository(Clanky::class)->findOneBy(['url'=>'vystaviste']);

        if (!$clanek)
            throw new NotFoundHttpException();
        return $this->render('vystaviste/index.html.twig', [
            'controller_name' => 'VystavisteController',
            'clanek' => $clanek,
            'paticka'=> false,
        ]);
    }
}
