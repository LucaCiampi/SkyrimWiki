<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221106153117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE skill (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__province AS SELECT id, name, description, image, created_at, modified_at FROM province');
        $this->addSql('DROP TABLE province');
        $this->addSql('CREATE TABLE province (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, image VARCHAR(511) DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , modified_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO province (id, name, description, image, created_at, modified_at) SELECT id, name, description, image, created_at, modified_at FROM __temp__province');
        $this->addSql('DROP TABLE __temp__province');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE skill');
        $this->addSql('CREATE TEMPORARY TABLE __temp__province AS SELECT id, name, description, image, created_at, modified_at FROM province');
        $this->addSql('DROP TABLE province');
        $this->addSql('CREATE TABLE province (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, image VARCHAR(511) DEFAULT NULL, created_at DATETIME NOT NULL, modified_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO province (id, name, description, image, created_at, modified_at) SELECT id, name, description, image, created_at, modified_at FROM __temp__province');
        $this->addSql('DROP TABLE __temp__province');
    }
}
