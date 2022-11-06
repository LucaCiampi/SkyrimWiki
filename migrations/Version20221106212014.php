<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221106212014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE city ADD COLUMN modified_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__city AS SELECT id, province_id, name, created_at, description, photo FROM city');
        $this->addSql('DROP TABLE city');
        $this->addSql('CREATE TABLE city (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, province_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , description CLOB DEFAULT NULL, photo VARCHAR(511) DEFAULT NULL, CONSTRAINT FK_2D5B0234E946114A FOREIGN KEY (province_id) REFERENCES province (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO city (id, province_id, name, created_at, description, photo) SELECT id, province_id, name, created_at, description, photo FROM __temp__city');
        $this->addSql('DROP TABLE __temp__city');
        $this->addSql('CREATE INDEX IDX_2D5B0234E946114A ON city (province_id)');
    }
}
