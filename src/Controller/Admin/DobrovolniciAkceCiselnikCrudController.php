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
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use function PHPUnit\Framework\throwException;

class DobrovolniciAkceCiselnikCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return DobrovolniciAkceCiselnik::class;
    }
    public function __construct(private readonly Security $security)
    {
    }

    public function configureFields(string $pageName): iterable
    {
        if (!$this->security->isGranted('ROLE_DOBROVOLNICI'))
            throw new AccessDeniedException('Access Denied');
        yield IdField::new('id')->hideOnForm();
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
