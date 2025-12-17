<?php

namespace App\Controller\Admin;

use App\Entity\Akce;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AkceCrudController extends AktualityCrudController
{
    public static function getEntityFqcn(): string
    {
        return Akce::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('new', 'New event')
            ->setPageTitle('edit', 'Edit event')
            ->setPageTitle('index', 'Events');
    }
    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);
        $actions->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action){
            return $action->setLabel('New event');
        });
        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        yield from parent::configureFields($pageName);
        yield NumberField::new('lat', 'Latitude');
        yield NumberField::new('lng', 'Longitude');
    }
}
