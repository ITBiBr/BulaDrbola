<?php

namespace App\Controller\Admin;

use App\Entity\EmailSubscription;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

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
        return $actions;
    }
}
