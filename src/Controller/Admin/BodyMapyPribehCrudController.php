<?php

namespace App\Controller\Admin;

use App\Entity\BodyMapyPribeh;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Finder\Exception\AccessDeniedException;

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

    public function __construct(private readonly Security $security)
    {
    }

    public function configureFields(string $pageName): iterable
    {
        if (!$this->security->isGranted('ROLE_EDITOR'))
            throw new AccessDeniedException('Access Denied');
        yield NumberField::new('lat', 'Latitude');
        yield NumberField::new('lng', 'Longitude');
        yield TextField::new('nazev' ,'Display Name');

        yield TextEditorField::new('pribehMista', 'Place Story');
        yield TextEditorField::new('zajimavosti', 'Interestings');

        yield ImageField::new('obrazek', 'Image')
            ->setBasePath($_ENV['PRIBEH_BASE_PATH'])
            ->setUploadDir($_ENV['PRIBEH_UPLOAD'])
            ->setFormTypeOption('multiple', false)
            ->setUploadedFileNamePattern('[year][month][day]-[timestamp]-[slug]-[contenthash].[extension]')
            ->setFormTypeOption('required', $pageName === Crud::PAGE_NEW)
            ->setFormTypeOption('allow_delete', true)
            ->setSortable(false);
    }
}
