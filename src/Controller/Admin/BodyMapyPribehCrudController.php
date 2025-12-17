<?php

namespace App\Controller\Admin;

use App\Entity\BodyMapyPribeh;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BodyMapyPribehCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BodyMapyPribeh::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('new', 'New Story Map Point')
            ->setPageTitle('edit', 'Edit Story Map Point')
            ->setPageTitle('index', 'Story Map Points');
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);
        $actions->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action){
            return $action->setLabel('New Story Map Point');
        });
        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        yield NumberField::new('lat', 'Latitude');
        yield NumberField::new('lng', 'Longitude');
        yield TextField::new('nazev' ,'Display Name');
        yield TextEditorField::new('pribehMista', 'Place Story');
        yield TextEditorField::new('zajimavosti', 'Interestings');
    }
}
