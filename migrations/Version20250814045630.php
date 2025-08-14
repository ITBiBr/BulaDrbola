<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250814045630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE materialy (id INT AUTO_INCREMENT NOT NULL, popis VARCHAR(255) NOT NULL, soubor VARCHAR(255) NOT NULL, nazev_souboru VARCHAR(255) DEFAULT NULL, typ_souboru VARCHAR(7) DEFAULT NULL, datum_vlozeni DATETIME NOT NULL, nazev VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materialy_materialy_kategorie (materialy_id INT NOT NULL, materialy_kategorie_id INT NOT NULL, INDEX IDX_2F6D86CB55222924 (materialy_id), INDEX IDX_2F6D86CBD50AB880 (materialy_kategorie_id), PRIMARY KEY(materialy_id, materialy_kategorie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materialy_kategorie (id INT AUTO_INCREMENT NOT NULL, kategorie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE materialy_materialy_kategorie ADD CONSTRAINT FK_2F6D86CB55222924 FOREIGN KEY (materialy_id) REFERENCES materialy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE materialy_materialy_kategorie ADD CONSTRAINT FK_2F6D86CBD50AB880 FOREIGN KEY (materialy_kategorie_id) REFERENCES materialy_kategorie (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE materialy_materialy_kategorie DROP FOREIGN KEY FK_2F6D86CB55222924');
        $this->addSql('ALTER TABLE materialy_materialy_kategorie DROP FOREIGN KEY FK_2F6D86CBD50AB880');
        $this->addSql('DROP TABLE materialy');
        $this->addSql('DROP TABLE materialy_materialy_kategorie');
        $this->addSql('DROP TABLE materialy_kategorie');
    }
}
