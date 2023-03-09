<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308224602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, categories_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_64C19C1A21214B7 (categories_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medicament (id INT AUTO_INCREMENT NOT NULL, nom_medicament VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, quatite INT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1A21214B7 FOREIGN KEY (categories_id) REFERENCES medicament (id)');
        $this->addSql('ALTER TABLE aarticle ADD published VARCHAR(255) NOT NULL, CHANGE description description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE rating DROP note');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1A21214B7');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE medicament');
        $this->addSql('ALTER TABLE aarticle DROP published, CHANGE description description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE rating ADD note INT NOT NULL');
    }
}
