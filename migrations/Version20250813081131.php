<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250813081131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aktuality ADD titulek VARCHAR(255) NOT NULL, CHANGE perex perex VARCHAR(255) NOT NULL, CHANGE datum datum DATE NOT NULL, CHANGE obrazek obrazek VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aktuality DROP titulek, CHANGE perex perex VARCHAR(255) DEFAULT NULL, CHANGE datum datum DATE DEFAULT NULL, CHANGE obrazek obrazek VARCHAR(255) DEFAULT NULL');
    }
}
