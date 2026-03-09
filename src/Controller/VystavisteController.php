<?php

namespace App\Controller;

use App\Entity\Clanky;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

final class VystavisteController extends ClankyController
{
    #[Route('/vystaviste', name: 'app_vystaviste')]
    public function vystaviste(EntityManagerInterface $entityManager, Security $security): Response
    {
        /*$datumZverejneni = new \DateTimeImmutable(
            $this->getParameter('datum_zverejneni')
        );

        $now = new \DateTimeImmutable();

        if ($now < $datumZverejneni  && !$security->isGranted('IS_AUTHENTICATED_FULLY')) { //muze se zverejnit nebo není user prihlasen
            // Přesměrování na showAktualita s URL 'vystaviste'
            return $this->showClanek('vystaviste', $entityManager);
        }*/

        return new RedirectResponse('slavnost-blahoreceni');

    }
}
