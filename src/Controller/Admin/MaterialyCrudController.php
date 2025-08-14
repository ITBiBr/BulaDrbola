<?php

namespace App\Controller\Admin;

use App\Entity\Materialy;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\File;

class MaterialyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Materialy::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('new', 'New Material')
            ->setPageTitle('edit', 'Edit Material')
            ->setPageTitle('index', 'Materials');;
    }
    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);
        $actions->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action){
            return $action->setLabel('New Material');
        });
        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
            yield IdField::new('id')->hideOnForm();
            yield TextField::new('NazevSouboru');
            yield TextField::new('Nazev');
            yield TextField::new('Popis');
            yield ImageField::new('Soubor', 'Inserted File')->onlyOnForms()
                ->setBasePath('files/')
                ->setUploadDir('public/files')
                ->setFormTypeOption('multiple', false)
                ->setUploadedFileNamePattern('[year]-[month]-[day]-[contenthash].[extension]')
                ->setFormTypeOption('attr', ['accept' => '.docx,.pdf'])
                ->setFileConstraints(new File([
                    'mimeTypes' => [
                        'application/pdf',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    ],
                    'mimeTypesMessage' => 'This file type is not supported.'
                ]));
            yield DateTimeField::new('DatumVlozeni', 'Insertion Date')
                ->setFormTypeOption('data', new \DateTime());
            yield AssociationField::new('Kategorie', 'Material Categories')->setFormTypeOption('by_reference', false)->formatValue(fn($value) => implode(', ', $value->toArray()));//->autocomplete();

    }
    
}
