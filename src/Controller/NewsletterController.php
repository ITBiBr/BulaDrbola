<?php

namespace App\Controller;

use App\Entity\EmailSubscription;
use App\Form\EmailSubscriptionType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class NewsletterController extends AbstractController
{
    #[Route('/newsletter', name: 'app_newsletter', methods: ['POST'])]
    public function subscribe(Request $request, EntityManagerInterface $em): Response
    {
        $subscription = new EmailSubscription();
        $form = $this->createForm(EmailSubscriptionType::class, $subscription);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($subscription);
            $em->flush();

            $this->addFlash('success', 'Děkujeme za přihlášení k odběru.');
        } else {
            foreach ($form->getErrors(true) as $error) {
                $this->addFlash('danger', $error->getMessage());
            }
        }

        return $this->redirect($request->headers->get('referer'). '/#newsletter');
    }
}
