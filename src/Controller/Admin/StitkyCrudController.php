<?php

namespace App\Controller\Admin;

use App\Entity\Stitky;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class StitkyCrudController extends AbstractCrudController
{
    use UrlTrait;
    public function __construct(private readonly Security $security)
    {
    }
    public static function getEntityFqcn(): string
    {
        return Stitky::class;
    }

    public function configureFields(string $pageName): iterable
    {
        if (!$this->security->isGranted('ROLE_EDITOR'))
            throw new AccessDeniedException('Access Denied');

        yield IdField::new('id')->hideOnForm();
        yield TextField::new('Titulek', 'Title');
        yield TextField::new('url', 'URL')->hideOnForm();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Stitky)
        {
            $entityInstance->setUrl($this->makeUniqueUrl($entityInstance->getNazevStitku(), $entityManager, Stitky::class));
        }

        parent::persistEntity($entityManager, $entityInstance);
    }
}
