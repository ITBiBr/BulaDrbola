<?php

namespace App\Controller\Admin;

use App\Entity\Dobrovolnici;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Finder\Exception\AccessDeniedException;
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

    public function __construct(private readonly Security $security)
    {
    }

    public function configureFields(string $pageName): iterable
    {
        if (!$this->security->isGranted('ROLE_DOBROVOLNICI'))
            throw new AccessDeniedException('Access Denied');
        yield IdField::new('Id')->hideOnForm();
        yield TextField::new('jmeno', 'Name');
        yield TextField::new('prijmeni', 'Surname');
        yield IntegerField::new('vek', 'Age');
        yield EmailField::new('email', 'E-mail');
        yield TextField::new('telefon', "Phone number");
        yield BooleanField::new('isSouhlasGdpr', 'GDPR consent')->hideOnIndex();
        yield DateTimeField::new('CreatedAt', 'Created At')->setDisabled();
        yield AssociationField::new('Akce', 'Activities')
            ->setFormTypeOption('multiple', true)
            ->setFormTypeOption('by_reference', false)
            ->formatValue(fn($value) => implode('<br>', $value->toArray()));
        yield BooleanField::new('isZkusenosti', 'Experiences')->hideOnIndex();
        yield TextareaField::new('zkusenosti', 'Experiences');
        yield TextareaField::new('vzkaz', 'Message');
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
        $sheet->setCellValue('H1', 'Aktivity');
        $sheet->setCellValue('I1', 'Zkušenosti');
        $sheet->setCellValue('J1', 'Zkušenosti');
        $sheet->setCellValue('K1', 'Vzkaz');

        $row = 2;
        foreach ($subscriptions as $subscription) {
            $sheet->setCellValue('A' . $row, $subscription->getId());
            $sheet->setCellValue('B' . $row, $subscription->getJmeno());
            $sheet->setCellValue('C' . $row, $subscription->getPrijmeni());
            $sheet->setCellValue('D' . $row, $subscription->getEmail());
            $sheet->setCellValue('E' . $row, $subscription->getTelefon());
            $sheet->setCellValue('F' . $row, $subscription->isSouhlasGdpr()?'Ano':'Ne');
            $sheet->setCellValue('G' . $row, $subscription->getCreatedAt()->format('Y-m-d H:i:s'));
            $aktivityEntita = $subscription->getAkce();
            $aktivity = '';
            $lastIndex = count($aktivityEntita) - 1;
            foreach ($aktivityEntita as $index => $aktivita) {
                $aktivity .= $aktivita->getPolozkaCiselniku();
                if ($index !== $lastIndex) {
                    $aktivity .= "\n"; // přidat zalomení jen pokud to není poslední položka
                }
            }
            $sheet->setCellValue('H' . $row, $aktivity);
            $sheet->setCellValue('I' . $row, $subscription->isZkusenosti()?'Ano':'Ne');
            $sheet->setCellValue('J' . $row, $subscription->getZkusenosti());
            $sheet->setCellValue('K' . $row, $subscription->getVzkaz());
            // nastavit wrap text pro celý řádek
            $sheet->getStyle($row)->getAlignment()->setWrapText(true);
            // nastavit vertikální zarovnání nahoru pro celý řádek
            $sheet->getStyle($row)->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
            // nastavit automatickou výšku řádku
            $sheet->getRowDimension($row)->setRowHeight(-1);

            $row++;
        }
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);
        $sheet->getColumnDimension('K')->setAutoSize(true);

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
