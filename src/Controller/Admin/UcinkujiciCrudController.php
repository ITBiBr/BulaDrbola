<?php

namespace App\Controller\Admin;

use App\Entity\Ucinkujici;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class UcinkujiciCrudController extends AbstractCrudController
{
    public function __construct(private readonly Security $security)
    {
    }

    public static function getEntityFqcn(): string
    {
        return Ucinkujici::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('new', 'New performer')
            ->setPageTitle('edit', 'Edit performer')
            ->setPageTitle('index', 'Performers');
    }
    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);
        $actions->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action){
            return $action->setLabel('New performer');
        });
        return $actions;
    }

    public function configureFields(string $pageName): iterable
    {
        if (!$this->security->isGranted('ROLE_EDITOR'))
            throw new AccessDeniedException('Access Denied');
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('jmeno', 'Name');
        yield ImageField::new('ObrazekPc', 'Image PC')
            ->setBasePath($_ENV['CLANKY_BASE_PATH'])
            ->setUploadDir($_ENV['CLANKY_UPLOAD'])
            ->setFormTypeOption('multiple', false)
            ->setUploadedFileNamePattern('[year][month][day]-[timestamp]-[contenthash].[extension]')
            ->setFormTypeOption('required', $pageName === Crud::PAGE_NEW)
            ->setFormTypeOption('allow_delete', false)
            ->setSortable(false);
        yield ImageField::new('Obrazek', 'Image')
            ->setBasePath($_ENV['CLANKY_BASE_PATH'])
            ->setUploadDir($_ENV['CLANKY_UPLOAD'])
            ->setFormTypeOption('multiple', false)
            ->setUploadedFileNamePattern('[year][month][day]-[timestamp]-[contenthash].[extension]')
            ->setFormTypeOption('required', $pageName === Crud::PAGE_NEW)
            ->setFormTypeOption('allow_delete', false)
            ->setSortable(false);
        yield TextEditorField::new('medailonek', 'Content');
        yield IntegerField::new('poradi', 'Order');
    }
}
