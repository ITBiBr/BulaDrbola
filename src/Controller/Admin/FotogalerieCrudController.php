<?php

namespace App\Controller\Admin;

use App\Entity\Fotogalerie;
use App\Form\DropzoneType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class FotogalerieCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Fotogalerie::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->addFormTheme('admin/form/dropzone_theme.html.twig')
            ->setPageTitle('new', 'New fotogallery')
            ->setPageTitle('edit', 'Edit fotogallery')
            ->setPageTitle('index', 'Fotogalleries');
    }
    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);
        $actions->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action){
            return $action->setLabel('New fotogallery');
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
        yield TextField::new('titulek', 'Title');
        yield Field::new('upload', 'Photo')
            ->setFormType(DropzoneType::class)
            ->setFormTypeOptions([
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'data-entity' => 'fotogalerie',
                    'data-entity-id' => $this->getContext()?->getEntity()?->getInstance()?->getId(),
                    'data-type' => 'image',
                ],
            ])
            ->onlyOnForms()
            ->setHelp('Content of this field saves automatically.');
    }
}
