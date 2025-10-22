<?php

namespace App\Controller\Admin;

use App\Entity\Dobrovolnici;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DobrovolniciCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Dobrovolnici::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('new', 'New Volunteer')
            ->setPageTitle('edit', 'Edit Volunteer')
            ->setPageTitle('index', 'Volunteers');;
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);
        $actions->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action){
            return $action->setLabel('New Volunteer');
        });
        $exportAction = Action::new('export_excel', 'Export do Excelu')
            ->linkToUrl(fn () => $this->generateUrl('admin_volunteers_export', [], UrlGeneratorInterface::ABSOLUTE_URL))
            ->createAsGlobalAction(); // Globální akce, není na konkrétní entitu

        $actions
            ->add(Crud::PAGE_INDEX, $exportAction);
        return $actions;
    }
    public function createEntity(string $entityFqcn)
    {
        $entity = new $entityFqcn();

        // Nastavíme boolean na true
        $entity->setIsSouhlasGdpr(true);

        return $entity;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('Id')->hideOnForm();
        yield TextField::new('jmeno', 'Name');
        yield TextField::new('prijmeni', 'Surname');
        yield EmailField::new('email', 'E-mail');
        yield TextField::new('telefon', "Phone number");
        yield BooleanField::new('isSouhlasGdpr', 'GDPR consent')->hideOnIndex();
        yield DateTimeField::new('CreatedAt', 'Created At')->setDisabled();
    }

    #[Route('/admin/export/volunteers', name: 'admin_volunteers_export')]
    public function exportToExcel(EntityManagerInterface $entityManager): StreamedResponse
    {
        $subscriptions = $entityManager->getRepository(Dobrovolnici::class)->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Hlavička
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Jméno');
        $sheet->setCellValue('C1', 'Přijmení');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Telefon');
        $sheet->setCellValue('F1', 'Souhlas s GDPR');
        $sheet->setCellValue('G1', 'Datum registrace');

        $row = 2;
        foreach ($subscriptions as $subscription) {
            $sheet->setCellValue('A' . $row, $subscription->getId());
            $sheet->setCellValue('B' . $row, $subscription->getJmeno());
            $sheet->setCellValue('C' . $row, $subscription->getPrijmeni());
            $sheet->setCellValue('D' . $row, $subscription->getEmail());
            $sheet->setCellValue('E' . $row, $subscription->getTelefon());
            $sheet->setCellValue('F' . $row, $subscription->isSouhlasGdpr()?'Ano':'Ne');
            $sheet->setCellValue('G' . $row, $subscription->getCreatedAt()->format('Y-m-d H:i:s'));
            $row++;
        }
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);

        $writer = new Xlsx($spreadsheet);

        $response = new StreamedResponse(function () use ($writer) {
            $writer->save('php://output');
        });

        $filename = 'dobrovolnici_' . date('Y-m-d_H-i-s') . '.xlsx';

        $disposition = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename
        );

        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        $response->headers->set('Content-Disposition', $disposition);

        return $response;
    }

}
