<?php

namespace App\Controller\Admin;

use App\Entity\NastaveniWebu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class NastaveniWebuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return NastaveniWebu::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('edit', 'Edit web settings')
            ->setPageTitle('index', 'Web settings');
    }
    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);
        $actions->disable(Action::DELETE, Action::BATCH_DELETE, Action::NEW);

        return $actions;
    }

    public function __construct(private readonly Security $security)
    {
    }

    public function configureFields(string $pageName): iterable
    {
        if (!$this->security->isGranted('ROLE_EDITOR'))
            throw new AccessDeniedException('Access Denied');
        yield TextField::new('identifikator','Identifier')->setDisabled(true);
        yield TextField::new('nastaveni','Settings')->setRequired(false);
    }
}
