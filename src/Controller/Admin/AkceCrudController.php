<?php

namespace App\Controller\Admin;

use App\Entity\Akce;
use App\Entity\Aktuality;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\File;

class AkceCrudController extends AktualityCrudController
{
    public static function getEntityFqcn(): string
    {
        return Akce::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('new', 'New event')
            ->setPageTitle('edit', 'Edit event')
            ->setPageTitle('index', 'Events');
    }
    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);
        $actions->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action){
            return $action->setLabel('New event');
        });
        return $actions;
    }

    public function configureFieldsChildren(string $pageName): iterable
    {
        yield DateField::new('DatumDo', 'Date To');
        yield NumberField::new('lat', 'Latitude');
        yield NumberField::new('lng', 'Longitude');
        yield TextField::new('MistoKonani','Event venue');
        yield ImageField::new('IlustraceObsahu', 'Poster')
            ->setBasePath($_ENV['AKTUALITY_BASE_PATH'])
            ->setUploadDir($_ENV['AKTUALITY_UPLOAD'])
            ->setFormTypeOption('multiple', false)
            ->setUploadedFileNamePattern('[year][month][day]-[timestamp]-[contenthash].[extension]')
            ->setFormTypeOption('allow_delete', true)
            ->setFormTypeOption('attr', ['accept' => '.doc,.docx,.jpg,.png,.pdf'])
            ->setFileConstraints(new File([
                'mimeTypes' => [
                    'application/pdf',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/msword',
                    'image/jpeg',
                    'image/png',
                ],
                'mimeTypesMessage' => 'Typ souboru není podporován.'
            ]))
            ->setSortable(false)
            ->hideOnIndex();
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Akce)
        {
            $entityInstance->setUrl($this->makeUniqueUrl($entityInstance->getTitulek(), $entityManager));
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    protected function makeUniqueUrl(string $original, EntityManagerInterface $em): string
    {
        $url = $originalUrl = $this->makeURL($original);

        $i = 2;

        while ($em->getRepository(Akce::class)->findOneBy(['url' => $url])) {
            $url = $originalUrl . '-' . $i;
            $i++;
        }

        return $url;
    }
}
