<?php

namespace App\Controller\Admin;

use App\Entity\TextyStranek;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class TextyStranekCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TextyStranek::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('edit', 'Edit page text')
            ->setPageTitle('index', 'Page texts');
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
        yield TextField::new('stranka', 'Page')->setDisabled(true);
        yield TextField::new('identifikator','Identifier')->setDisabled(true);
        yield TextField::new('nadpis','Title');
        yield TextEditorField::new('text');
    }
}
