<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308174808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE aarticle (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coment (id INT AUTO_INCREMENT NOT NULL, content VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reports (id INT AUTO_INCREMENT NOT NULL, message VARCHAR(255) NOT NULL, id_aarticle INT NOT NULL, id_uuser VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categorie CHANGE type_cat type_cat VARCHAR(30) NOT NULL, CHANGE des_cat des_cat VARCHAR(50) NOT NULL, CHANGE nom nom VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE don CHANGE titre titre VARCHAR(20) NOT NULL, CHANGE type type VARCHAR(30) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE aarticle');
        $this->addSql('DROP TABLE coment');
        $this->addSql('DROP TABLE reports');
        $this->addSql('ALTER TABLE categorie CHANGE type_cat type_cat VARCHAR(255) NOT NULL, CHANGE des_cat des_cat VARCHAR(255) NOT NULL, CHANGE nom nom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE don CHANGE titre titre VARCHAR(255) NOT NULL, CHANGE type type VARCHAR(255) NOT NULL');
    }
}
