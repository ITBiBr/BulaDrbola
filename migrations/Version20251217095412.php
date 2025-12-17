<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251217095412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE akce (id INT AUTO_INCREMENT NOT NULL, perex LONGTEXT NOT NULL, obsah LONGTEXT NOT NULL, datum DATE NOT NULL, datum_zobrazeni_od DATETIME NOT NULL, obrazek VARCHAR(255) NOT NULL, titulek VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, ilustrace_obsahu VARCHAR(255) DEFAULT NULL, video VARCHAR(255) DEFAULT NULL, obsah_pokracovani LONGTEXT DEFAULT NULL, lat DOUBLE PRECISION DEFAULT NULL, lng DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE akce');
    }
}
