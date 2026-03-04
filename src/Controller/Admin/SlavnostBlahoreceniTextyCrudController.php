<?php

namespace App\Controller\Admin;

use App\Entity\SlavnostBlahoreceniTexty;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class SlavnostBlahoreceniTextyCrudController extends AbstractCrudController
{
    public function __construct(private readonly Security $security)
    {
    }
    public static function getEntityFqcn(): string
    {
        return SlavnostBlahoreceniTexty::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('new', 'New text')
            ->setPageTitle('edit', 'Edit text')
            ->setPageTitle('index', 'Texts');
    }
    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);
        $actions->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action){
            return $action->setLabel('New text');
        });
        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        if (!$this->security->isGranted('ROLE_EDITOR'))
            throw new AccessDeniedException('Access Denied');
        yield TextField::new('Titulek','Title');
        yield TextEditorField::new('Text', 'Text');
        yield AssociationField::new('Kategorie' , 'Category');
        yield IntegerField::new('priorita', 'Priority');
    }
}
