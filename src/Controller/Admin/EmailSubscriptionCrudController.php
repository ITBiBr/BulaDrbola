<?php

namespace App\Controller\Admin;

use App\Entity\EmailSubscription;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EmailSubscriptionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EmailSubscription::class;
    }


    public function configureFields(string $pageName): iterable
    {

           yield IdField::new('id')->hideOnForm();
           yield EmailField::new('email' ,'E-mail');
           yield DateTimeField::new('createdAt' , 'Created At')->hideOnForm();
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('new', 'New E-mail')
            ->setPageTitle('edit', 'Edit E-mail')
            ->setPageTitle('index', 'Email Subscription');;
    }
    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);
        $actions->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action){
            return $action->setLabel('New E-mail');
        });
        $exportAction = Action::new('export_excel', 'Export do Excelu')
            ->linkToUrl(fn () => $this->generateUrl('admin_email_subscription_export', [], UrlGeneratorInterface::ABSOLUTE_URL))
            ->createAsGlobalAction(); // Globální akce, není na konkrétní entitu

        $actions
            ->add(Crud::PAGE_INDEX, $exportAction);

        return $actions;
    }

    #[Route('/admin/export/email-subscription', name: 'admin_email_subscription_export')]
    public function exportToExcel(EntityManagerInterface $entityManager): StreamedResponse
    {
        $subscriptions = $entityManager->getRepository(EmailSubscription::class)->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Hlavička
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'E-mail');
        $sheet->setCellValue('C1', 'Datum registrace');

        $row = 2;
        foreach ($subscriptions as $subscription) {
            $sheet->setCellValue('A' . $row, $subscription->getId());
            $sheet->setCellValue('B' . $row, $subscription->getEmail());
            $sheet->setCellValue('C' . $row, $subscription->getCreatedAt()->format('Y-m-d H:i:s'));
            $row++;
        }
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $writer = new Xlsx($spreadsheet);

        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });

        $filename = 'email_subscriptions_' . date('Y-m-d_H-i-s') . '.xlsx';

        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        );

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }


}
