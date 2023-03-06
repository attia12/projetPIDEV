<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230304211419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation ADD locaux_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A62ADAA560 FOREIGN KEY (locaux_id) REFERENCES local (id)');
        $this->addSql('CREATE INDEX IDX_964685A62ADAA560 ON consultation (locaux_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A62ADAA560');
        $this->addSql('DROP INDEX IDX_964685A62ADAA560 ON consultation');
        $this->addSql('ALTER TABLE consultation DROP locaux_id');
    }
}
