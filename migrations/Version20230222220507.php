<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230222220507 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE local ADD locales_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE local ADD CONSTRAINT FK_8BD688E8164006B8 FOREIGN KEY (locales_id) REFERENCES consultation (id)');
        $this->addSql('CREATE INDEX IDX_8BD688E8164006B8 ON local (locales_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE local DROP FOREIGN KEY FK_8BD688E8164006B8');
        $this->addSql('DROP INDEX IDX_8BD688E8164006B8 ON local');
        $this->addSql('ALTER TABLE local DROP locales_id');
    }
}
