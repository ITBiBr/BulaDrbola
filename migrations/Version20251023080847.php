<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251023080847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dobrovolnici_dobrovolnici_akce_ciselnik (dobrovolnici_id INT NOT NULL, dobrovolnici_akce_ciselnik_id INT NOT NULL, INDEX IDX_4DC4DC53AA2DC47A (dobrovolnici_id), INDEX IDX_4DC4DC531E91312 (dobrovolnici_akce_ciselnik_id), PRIMARY KEY(dobrovolnici_id, dobrovolnici_akce_ciselnik_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dobrovolnici_akce_ciselnik (id INT AUTO_INCREMENT NOT NULL, polozka_ciselniku VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dobrovolnici_dobrovolnici_akce_ciselnik ADD CONSTRAINT FK_4DC4DC53AA2DC47A FOREIGN KEY (dobrovolnici_id) REFERENCES dobrovolnici (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dobrovolnici_dobrovolnici_akce_ciselnik ADD CONSTRAINT FK_4DC4DC531E91312 FOREIGN KEY (dobrovolnici_akce_ciselnik_id) REFERENCES dobrovolnici_akce_ciselnik (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dobrovolnici_dobrovolnici_akce_ciselnik DROP FOREIGN KEY FK_4DC4DC53AA2DC47A');
        $this->addSql('ALTER TABLE dobrovolnici_dobrovolnici_akce_ciselnik DROP FOREIGN KEY FK_4DC4DC531E91312');
        $this->addSql('DROP TABLE dobrovolnici_dobrovolnici_akce_ciselnik');
        $this->addSql('DROP TABLE dobrovolnici_akce_ciselnik');
    }
}
