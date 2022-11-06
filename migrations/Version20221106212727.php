<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221106212727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE follower (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, race_id INTEGER NOT NULL, living_in_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , modified_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_B9D609466E59D40D FOREIGN KEY (race_id) REFERENCES race (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B9D60946D6F07E95 FOREIGN KEY (living_in_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B9D609466E59D40D ON follower (race_id)');
        $this->addSql('CREATE INDEX IDX_B9D60946D6F07E95 ON follower (living_in_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__city AS SELECT id, province_id, name, created_at, description, photo, modified_at FROM city');
        $this->addSql('DROP TABLE city');
        $this->addSql('CREATE TABLE city (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, province_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , description CLOB DEFAULT NULL, photo VARCHAR(511) DEFAULT NULL, modified_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_2D5B0234E946114A FOREIGN KEY (province_id) REFERENCES province (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO city (id, province_id, name, created_at, description, photo, modified_at) SELECT id, province_id, name, created_at, description, photo, modified_at FROM __temp__city');
        $this->addSql('DROP TABLE __temp__city');
        $this->addSql('CREATE INDEX IDX_2D5B0234E946114A ON city (province_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE follower');
        $this->addSql('CREATE TEMPORARY TABLE __temp__city AS SELECT id, province_id, name, created_at, description, photo, modified_at FROM city');
        $this->addSql('DROP TABLE city');
        $this->addSql('CREATE TABLE city (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, province_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , description CLOB DEFAULT NULL, photo VARCHAR(511) DEFAULT NULL, modified_at DATETIME DEFAULT NULL, CONSTRAINT FK_2D5B0234E946114A FOREIGN KEY (province_id) REFERENCES province (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO city (id, province_id, name, created_at, description, photo, modified_at) SELECT id, province_id, name, created_at, description, photo, modified_at FROM __temp__city');
        $this->addSql('DROP TABLE __temp__city');
        $this->addSql('CREATE INDEX IDX_2D5B0234E946114A ON city (province_id)');
    }
}
