<?php

namespace App\Controller\Admin;

use App\Entity\Materialy;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints\File;

class MaterialyCrudController extends AbstractCrudController
{

    public function __construct(private readonly RequestStack $requestStack, private readonly Security $security)
    {
    }
    public static function getEntityFqcn(): string
    {
        return Materialy::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('new', 'New Material')
            ->setPageTitle('edit', 'Edit Material')
            ->setPageTitle('index', 'Materials');;
    }
    public function configureActions(Actions $actions): Actions
    {
        $actions = parent::configureActions($actions);
        $actions->update(Crud::PAGE_INDEX, Action::NEW, function(Action $action){
            return $action->setLabel('New Material');
        });
        return $actions;
    }


    public function configureFields(string $pageName): iterable
    {
        if (!$this->security->isGranted('ROLE_EDITOR'))
            throw new AccessDeniedException('Access Denied');
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('NazevSouboru','File Name')->hideOnForm();
        yield TextField::new('TypSouboru','File Type')->hideOnForm();
        yield TextField::new('Nazev', 'Display Name');
        yield TextField::new('Popis', 'File Description')->formatValue(function ($value, $entity) {
            if (!$value) {
                return '';
            }

            return mb_strlen($value) > 35
                ? mb_substr($value, 0, 35) . '...'
                : $value;
        });
        yield ImageField::new('Soubor', 'Inserted File')->onlyOnForms()
            ->setBasePath('files/')
            ->setUploadDir('public/files')
            ->setFormTypeOption('multiple', false)
            ->setUploadedFileNamePattern('[year]-[month]-[day]-[contenthash].[extension]')
            ->setFormTypeOption('attr', ['accept' => '.doc,.docx,.jpg,.mp3,.pdf,.zip'])
            ->setFileConstraints(new File([
                'mimeTypes' => [
                    'application/pdf',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/msword',
                    'image/jpeg',
                    'audio/mpeg',
                    'application/zip',
                    'application/x-zip-compressed',
                ],
                'mimeTypesMessage' => 'Typ souboru není podporován.'
            ]))
            ->setFormTypeOption('required', $pageName === Crud::PAGE_NEW)
            ->setFormTypeOption('allow_delete', false);
        yield TextField::new('NazevSouboru', 'File Name')
            ->onlyOnForms()
            ->setFormTypeOption('disabled', true);
        yield TextField::new('TypSouboru', 'File Type')
            ->onlyOnForms()
            ->setFormTypeOption('disabled', true);

        yield DateTimeField::new('DatumVlozeni', 'Insertion Date')
            ->setFormTypeOption('data', new \DateTime());
        yield AssociationField::new('Kategorie', 'Material Categories')->setFormTypeOption('by_reference', false)->formatValue(fn($value) => implode(', ', $value->toArray()));//->autocomplete();

    }

   public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
   {
       $this->handleOriginalFilename($entityInstance);

       parent::persistEntity($entityManager, $entityInstance);
   }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {

        $this->handleOriginalFilename($entityInstance);

        parent::updateEntity($entityManager, $entityInstance);
    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {

        $soubor = $entityInstance->getSoubor();

        if ($soubor) {
            $filesystem = new Filesystem();
            $souborPath = $this->getParameter('kernel.project_dir') . '/public/files/' . $soubor;

            if ($filesystem->exists($souborPath)) {
                try {
                    $filesystem->remove($souborPath);
                } catch (\Exception $e) {

                }
            }
        }

        parent::deleteEntity($entityManager, $entityInstance);
    }

    private function handleOriginalFilename($entity): void
    {

        $request = $this->requestStack->getCurrentRequest();

        $uploadedFile = $request->files->get('Materialy')['Soubor'] ?? null;

        // Získáme původní název souboru
        if ($uploadedFile['file']) {
            $originalFilename = $uploadedFile['file']->getClientOriginalName();


            $pathInfo = pathinfo($originalFilename);
            $nazev = $this->sanitizeFilename($pathInfo['filename']) ?? null;
            $typ = $pathInfo['extension'] ?? null;
            $entity->setNazevSouboru($nazev);
            $entity->setTypSouboru($typ);
        }
    }


    function sanitizeFilename(string $filename): string
    {
        // 1. Odstranění diakritiky
        $filename = transliterator_transliterate('Any-Latin; Latin-ASCII; [\u0080-\u7fff] remove', $filename);

        // 2. Nahrazení mezer podtržítky
        $filename = preg_replace('/\s+/', '_', $filename);

        // 3. Odstranění nepovolených znaků (ponechá jen písmena, čísla, pomlčku, podtržítko)
        $filename = preg_replace('/[^A-Za-z0-9\-_]/', '', $filename);

        // 4. Volitelně: převede na lowercase
        $filename = strtolower($filename);

        return $filename;
    }
}
