<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260304100812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE slavnost_blahoreceni_texty (id INT AUTO_INCREMENT NOT NULL, kategorie_id INT DEFAULT NULL, titulek VARCHAR(255) NOT NULL, text VARCHAR(255) NOT NULL, INDEX IDX_68D380DBBAF991D3 (kategorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE slavnost_blahoreceni_texty ADD CONSTRAINT FK_68D380DBBAF991D3 FOREIGN KEY (kategorie_id) REFERENCES slavnost_blahoreceni_kategorie (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE slavnost_blahoreceni_texty DROP FOREIGN KEY FK_68D380DBBAF991D3');
        $this->addSql('DROP TABLE slavnost_blahoreceni_texty');
    }
}
