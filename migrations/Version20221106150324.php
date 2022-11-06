<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221106150324 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE province ADD COLUMN created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE province ADD COLUMN modified_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__province AS SELECT id, name, description, image FROM province');
        $this->addSql('DROP TABLE province');
        $this->addSql('CREATE TABLE province (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, image VARCHAR(511) DEFAULT NULL)');
        $this->addSql('INSERT INTO province (id, name, description, image) SELECT id, name, description, image FROM __temp__province');
        $this->addSql('DROP TABLE __temp__province');
    }
}
