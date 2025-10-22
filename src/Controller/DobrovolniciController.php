<?php

namespace App\Controller;

use App\Entity\Dobrovolnici;
use App\Form\DobrovolniciType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DobrovolniciController extends AbstractController
{
    #[Route('/dobrovolnici', name: 'app_dobrovolnici')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dobrovolnik = new Dobrovolnici();
        $dobrovolniciForm = $this->createForm(DobrovolniciType::class, $dobrovolnik);

        $dobrovolniciForm->handleRequest($request);


        if ($dobrovolniciForm->isSubmitted() && $dobrovolniciForm->isValid()) {
            $entityManager->persist($dobrovolnik);
            $entityManager->flush();

            $this->addFlash('success', 'Registrace proběhla úspěšně!');
            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('dobrovolnici/index.html.twig', [
            'controller_name' => 'DobrovolniciController',
            'dobrovolniciForm' => $dobrovolniciForm,
            'paticka'=> true,
        ]);
    }
}
