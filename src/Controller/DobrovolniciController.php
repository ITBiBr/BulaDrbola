<?php

namespace App\Controller;

use App\Entity\Dobrovolnici;
use App\Form\DobrovolniciType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

final class DobrovolniciController extends AbstractController
{
    #[Route('/dobrovolnici', name: 'app_dobrovolnici')]
    public function index(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $dobrovolnik = new Dobrovolnici();
        $dobrovolniciForm = $this->createForm(DobrovolniciType::class, $dobrovolnik);

        $dobrovolniciForm->handleRequest($request);


        if ($dobrovolniciForm->isSubmitted() && $dobrovolniciForm->isValid()) {
            $entityManager->persist($dobrovolnik);
            $entityManager->flush();
            $akceDobrovolniku = '';
            foreach ($dobrovolnik->getAkce() as $akce)
            {
                $akceDobrovolniku.= $akce->getPolozkaCiselniku().'<br>';
            }
            $gdpr = $dobrovolnik->isSouhlasGdpr()?'Ano':'Ne';
            $zkusenosti = $dobrovolnik->isZkusenosti()?'Ano':'Ne';
            $email = (new Email())
                ->from($this->getParameter('mail_from'))
                ->to($this->getParameter('mail_to'))
                ->subject('BulaDrbola.cz - Nový dobrovolník')
                ->html("
                    <h2>Nový dobrovolník</h2>
                    <p><strong>Jméno:</strong> {$dobrovolnik->getJmeno()}</p>
                    <p><strong>Příjmení:</strong> {$dobrovolnik->getPrijmeni()}</p>
                    <p><strong>Datum:</strong> {$dobrovolnik->getCreatedAt()?->format('j. n. Y')}</p>
                    <p><strong>Souhlas s GDPR:</strong> {$gdpr}</p>
                    <p><strong>Věk:</strong> {$dobrovolnik->getVek()}</p>
                    <p><strong>E-mail:</strong> {$dobrovolnik->getEmail()}</p>
                    <p><strong>Telefon:</strong> {$dobrovolnik->getTelefon()}</p>
                    <p><strong>Akce:</strong> {$akceDobrovolniku}</p>
                    <p><strong>Zkušenosti:</strong> {$zkusenosti}</p>
                    <p>{$dobrovolnik->getZkusenosti()}</p>
                    <p><strong>Vzkaz:</strong> {$dobrovolnik->getVzkaz()}</p>
                    
                ");

            $mailer->send($email);


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
