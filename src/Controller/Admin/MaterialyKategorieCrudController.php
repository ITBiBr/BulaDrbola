<?php

namespace App\Controller\Admin;

use App\Entity\MaterialyKategorie;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MaterialyKategorieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MaterialyKategorie::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('new', 'New Material Category')
            ->setPageTitle('edit', 'Edit Material Category')
            ->setPageTitle('index', 'Material Categories');;
    }

    public function configureFields(string $pageName): iterable
    {

            yield IdField::new('id')->hideOnForm();
            yield TextField::new('Kategorie');

    }

    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);
        $actions->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action){
            return $action->setLabel('New Category');
        });
        return $actions;
    }

}
