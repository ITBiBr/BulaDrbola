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
        yield TextEditorField::new('obsah');
        yield DateField::new('Datum', 'Date');
        yield DateTimeField::new('DatumZobrazeniOd', 'Show content from')
            ->setFormTypeOption('data', new \DateTime());
        yield ImageField::new('Obrazek', 'Image')
            ->setBasePath($_ENV['AKTUALITY_BASE_PATH'])
            ->setUploadDir($_ENV['AKTUALITY_UPLOAD'])
            ->setFormTypeOption('multiple', false)
            ->setUploadedFileNamePattern('[year][month][day]-[timestamp]-[slug]-[contenthash].[extension]')
            ->setFormTypeOption('required', $pageName === Crud::PAGE_NEW)
            ->setFormTypeOption('allow_delete', false)
            ->setSortable(false);


    }
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Aktuality)
        {
            $entityInstance->setUrl($this->makeUniqueUrl($entityInstance->getTitulek(), $entityManager));
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {

        $soubor = $entityInstance->getObrazek();

        if ($soubor) {
            $filesystem = new Filesystem();
            $souborPath = $this->getParameter('kernel.project_dir') . '/public/images/aktuality/' . $soubor;

            if ($filesystem->exists($souborPath)) {
                try {
                    $filesystem->remove($souborPath);
                } catch (\Exception $e) {

                }
            }
        }

        parent::deleteEntity($entityManager, $entityInstance);
    }

    private function makeURL(string $url): string
    {
        // 1. Odstranění diakritiky
        $url = transliterator_transliterate('Any-Latin; Latin-ASCII; [\u0080-\u7fff] remove', $url);

        // 2. Nahrazení mezer pomlckami
        $url = preg_replace('/\s+/', '-', $url);

        // 3. Odstranění nepovolených znaků (ponechá jen písmena, čísla, pomlčku, podtržítko)
        $url = preg_replace('/[^A-Za-z0-9\-_]/', '', $url);

        // 4. Volitelně: převede na lowercase
        $url = strtolower($url);

        return $url;
    }

    private function makeUniqueUrl(string $original, EntityManagerInterface $em): string
    {
        $url = $originalUrl = $this->makeURL($original);

        $i = 2;

        while ($em->getRepository(Aktuality::class)->findOneBy(['url' => $url])) {
            $url = $originalUrl . '-' . $i;
            $i++;
        }

        return $url;
    }
}
