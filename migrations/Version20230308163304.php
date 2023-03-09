<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308163304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, type_cat VARCHAR(255) NOT NULL, des_cat VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_cat (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE don ADD id_cat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE don ADD CONSTRAINT FK_F8F081D9C09A1CAE FOREIGN KEY (id_cat_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_F8F081D9C09A1CAE ON don (id_cat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE don DROP FOREIGN KEY FK_F8F081D9C09A1CAE');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE type_cat');
        $this->addSql('DROP INDEX IDX_F8F081D9C09A1CAE ON don');
        $this->addSql('ALTER TABLE don DROP id_cat_id');
    }
}
