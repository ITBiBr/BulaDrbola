<?php

namespace App\Controller\Admin;

use App\Entity\Aktuality;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AktualityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Aktuality::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('new', 'New news')
            ->setPageTitle('edit', 'Edit news')
            ->setPageTitle('index', 'News');
    }
    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);
        $actions->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action){
            return $action->setLabel('New news');
        });
        return $actions;
    }
    public function configureFields(string $pageName): iterable
    {

            yield IdField::new('id')->hideOnForm();
            yield TextEditorField::new('perex');
            yield TextEditorField::new('obsah');
            yield DateTimeField::new('DatumZobrazeniOd', 'Show content from')
                ->setFormTypeOption('data', new \DateTime());

    }

}
