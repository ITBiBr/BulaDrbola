<?php

namespace App\Controller\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;

trait DeleteFilesTrait
{
    public function deleteEntityFiles(EntityManagerInterface $entityManager, $entityInstance, array $soubory, string $uploadDir): void
    {
        $filesystem = new Filesystem();
        $basePath = $this->getParameter('kernel.project_dir') . '/' . $uploadDir;

        foreach ($soubory as $soubor) {
            if ($soubor) {
                $souborPath = $basePath . $soubor;

                if ($filesystem->exists($souborPath)) {
                    try {
                        $filesystem->remove($souborPath);
                    } catch (\Exception $e) {
                        // můžeš logovat, pokud chceš
                    }
                }
            }
        }
    }
}