<?php

namespace App\Controller\Admin;

use App\Entity\DobrovolniciAkceCiselnik;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DobrovolniciAkceCiselnikCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DobrovolniciAkceCiselnik::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id');
        yield TextField::new('polozkaCiselniku', 'Activity');
        yield BooleanField::new('isActive', 'Active');

    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('new', 'New Activity')
            ->setPageTitle('edit', 'Edit Activity')
            ->setPageTitle('index', 'Volunteer Activities');
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);
        $actions->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
            return $action->setLabel('New Activity');
        });
        $actions->disable(Action::DELETE);
        $actions->disable(Action::BATCH_DELETE);
        return $actions;
    }
}
