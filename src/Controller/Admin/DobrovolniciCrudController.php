<?php

namespace App\Controller\Admin;

use App\Entity\Dobrovolnici;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

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
        yield BooleanField::new('isSouhlasGdpr', 'GDPR consent');
        yield DateTimeField::new('CreatedAt', 'Created At')->setDisabled();
    }

}
