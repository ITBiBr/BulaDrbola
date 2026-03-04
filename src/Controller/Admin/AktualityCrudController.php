<?php

namespace App\Controller\Admin;

use App\Entity\Aktuality;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class AktualityCrudController extends AbstractCrudController
{
    use UrlTrait;
    use DeleteFilesTrait;
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
    public function __construct(private readonly Security $security)
    {
    }

    public function configureFields(string $pageName): iterable
    {
        if (!$this->security->isGranted('ROLE_EDITOR'))
            throw new AccessDeniedException('Access Denied');

        yield IdField::new('id')->hideOnForm();
        yield TextField::new('Titulek', 'Title');
        yield TextField::new('url', 'URL')->hideOnForm();
        yield TextEditorField::new('perex');
        yield TextEditorField::new('obsah', 'Content');

        yield TextField::new('Video', 'Video (YouTube ID)')->hideOnIndex();
        yield DateField::new('Datum', 'Date');
        yield DateTimeField::new('DatumZobrazeniOd', 'Show content from')
            ->setFormTypeOption('data', new \DateTime());
        yield ImageField::new('Obrazek', 'Image')
            ->setBasePath($_ENV['AKTUALITY_BASE_PATH'])
            ->setUploadDir($_ENV['AKTUALITY_UPLOAD'])
            ->setFormTypeOption('multiple', false)
            ->setUploadedFileNamePattern('[year][month][day]-[timestamp]-[contenthash].[extension]')
            ->setFormTypeOption('required', $pageName === Crud::PAGE_NEW)
            ->setFormTypeOption('allow_delete', false)
            ->setSortable(false);

        yield from $this->configureFieldsChildren($pageName);

    }
    public function configureFieldsChildren(string $pageName):iterable
    {
        yield ImageField::new('IlustraceObsahu', 'Illustration in the middle of the content')
            ->setBasePath($_ENV['AKTUALITY_BASE_PATH'])
            ->setUploadDir($_ENV['AKTUALITY_UPLOAD'])
            ->setFormTypeOption('multiple', false)
            ->setUploadedFileNamePattern('[year][month][day]-[timestamp]-[contenthash].[extension]')
            ->setFormTypeOption('allow_delete', true)
            ->setSortable(false)
            ->hideOnIndex();
        yield TextEditorField::new('ObsahPokracovani' ,'Article content - continued')->hideOnIndex();
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $soubory = [
            $entityInstance->getObrazek(),
            $entityInstance->getIlustraceObsahu(),
        ];

        $this->deleteEntityFiles($entityManager,$entityInstance,$soubory,$_ENV['AKTUALITY_UPLOAD']);

        parent::deleteEntity($entityManager, $entityInstance);
    }
}
