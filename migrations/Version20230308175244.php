<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230308175244 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rating (id INT AUTO_INCREMENT NOT NULL, article_id_id INT DEFAULT NULL, note INT NOT NULL, INDEX IDX_D88926228F3EC46 (article_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D88926228F3EC46 FOREIGN KEY (article_id_id) REFERENCES aarticle (id)');
        $this->addSql('ALTER TABLE coment ADD id_article VARCHAR(255) NOT NULL, DROP content, DROP author');
        $this->addSql('ALTER TABLE reports DROP id_aarticle, DROP id_uuser, CHANGE message message LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D88926228F3EC46');
        $this->addSql('DROP TABLE rating');
        $this->addSql('ALTER TABLE coment ADD author VARCHAR(255) NOT NULL, CHANGE id_article content VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reports ADD id_aarticle INT NOT NULL, ADD id_uuser VARCHAR(255) NOT NULL, CHANGE message message VARCHAR(255) NOT NULL');
    }
}
