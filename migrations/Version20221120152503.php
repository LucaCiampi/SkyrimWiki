<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221120152503 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__city AS SELECT id, province_id, name, created_at, description, photo, modified_at FROM city');
        $this->addSql('DROP TABLE city');
        $this->addSql('CREATE TABLE city (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, province_id INTEGER DEFAULT NULL, author_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , description CLOB DEFAULT NULL, photo VARCHAR(511) DEFAULT NULL, modified_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_2D5B0234E946114A FOREIGN KEY (province_id) REFERENCES province (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_2D5B0234F675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO city (id, province_id, name, created_at, description, photo, modified_at) SELECT id, province_id, name, created_at, description, photo, modified_at FROM __temp__city');
        $this->addSql('DROP TABLE __temp__city');
        $this->addSql('CREATE INDEX IDX_2D5B0234E946114A ON city (province_id)');
        $this->addSql('CREATE INDEX IDX_2D5B0234F675F31B ON city (author_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__follower AS SELECT id, race_id, living_in_id, name, created_at, modified_at, image, biography FROM follower');
        $this->addSql('DROP TABLE follower');
        $this->addSql('CREATE TABLE follower (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, race_id INTEGER NOT NULL, living_in_id INTEGER DEFAULT NULL, author_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , modified_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , image VARCHAR(511) DEFAULT NULL, biography CLOB DEFAULT NULL, CONSTRAINT FK_B9D609466E59D40D FOREIGN KEY (race_id) REFERENCES race (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B9D60946D6F07E95 FOREIGN KEY (living_in_id) REFERENCES city (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B9D60946F675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO follower (id, race_id, living_in_id, name, created_at, modified_at, image, biography) SELECT id, race_id, living_in_id, name, created_at, modified_at, image, biography FROM __temp__follower');
        $this->addSql('DROP TABLE __temp__follower');
        $this->addSql('CREATE INDEX IDX_B9D60946D6F07E95 ON follower (living_in_id)');
        $this->addSql('CREATE INDEX IDX_B9D609466E59D40D ON follower (race_id)');
        $this->addSql('CREATE INDEX IDX_B9D60946F675F31B ON follower (author_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__province AS SELECT id, name, description, image, created_at, modified_at FROM province');
        $this->addSql('DROP TABLE province');
        $this->addSql('CREATE TABLE province (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, image VARCHAR(511) DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , modified_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_4ADAD40BF675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO province (id, name, description, image, created_at, modified_at) SELECT id, name, description, image, created_at, modified_at FROM __temp__province');
        $this->addSql('DROP TABLE __temp__province');
        $this->addSql('CREATE INDEX IDX_4ADAD40BF675F31B ON province (author_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__race AS SELECT id, homeland_id, name, created_at, modified_at, description, image FROM race');
        $this->addSql('DROP TABLE race');
        $this->addSql('CREATE TABLE race (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, homeland_id INTEGER DEFAULT NULL, author_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , modified_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , description CLOB DEFAULT NULL, image VARCHAR(511) DEFAULT NULL, CONSTRAINT FK_DA6FBBAF10A31E74 FOREIGN KEY (homeland_id) REFERENCES province (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_DA6FBBAFF675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO race (id, homeland_id, name, created_at, modified_at, description, image) SELECT id, homeland_id, name, created_at, modified_at, description, image FROM __temp__race');
        $this->addSql('DROP TABLE __temp__race');
        $this->addSql('CREATE INDEX IDX_DA6FBBAF10A31E74 ON race (homeland_id)');
        $this->addSql('CREATE INDEX IDX_DA6FBBAFF675F31B ON race (author_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__skill AS SELECT id, name, created_at, modified_at, image FROM skill');
        $this->addSql('DROP TABLE skill');
        $this->addSql('CREATE TABLE skill (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , modified_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , image VARCHAR(511) DEFAULT NULL, CONSTRAINT FK_5E3DE477F675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO skill (id, name, created_at, modified_at, image) SELECT id, name, created_at, modified_at, image FROM __temp__skill');
        $this->addSql('DROP TABLE __temp__skill');
        $this->addSql('CREATE INDEX IDX_5E3DE477F675F31B ON skill (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__city AS SELECT id, province_id, name, created_at, description, photo, modified_at FROM city');
        $this->addSql('DROP TABLE city');
        $this->addSql('CREATE TABLE city (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, province_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , description CLOB DEFAULT NULL, photo VARCHAR(511) DEFAULT NULL, modified_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_2D5B0234E946114A FOREIGN KEY (province_id) REFERENCES province (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO city (id, province_id, name, created_at, description, photo, modified_at) SELECT id, province_id, name, created_at, description, photo, modified_at FROM __temp__city');
        $this->addSql('DROP TABLE __temp__city');
        $this->addSql('CREATE INDEX IDX_2D5B0234E946114A ON city (province_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__follower AS SELECT id, race_id, living_in_id, name, created_at, modified_at, image, biography FROM follower');
        $this->addSql('DROP TABLE follower');
        $this->addSql('CREATE TABLE follower (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, race_id INTEGER NOT NULL, living_in_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , modified_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , image VARCHAR(511) DEFAULT NULL, biography CLOB DEFAULT NULL, CONSTRAINT FK_B9D609466E59D40D FOREIGN KEY (race_id) REFERENCES race (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B9D60946D6F07E95 FOREIGN KEY (living_in_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO follower (id, race_id, living_in_id, name, created_at, modified_at, image, biography) SELECT id, race_id, living_in_id, name, created_at, modified_at, image, biography FROM __temp__follower');
        $this->addSql('DROP TABLE __temp__follower');
        $this->addSql('CREATE INDEX IDX_B9D609466E59D40D ON follower (race_id)');
        $this->addSql('CREATE INDEX IDX_B9D60946D6F07E95 ON follower (living_in_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__province AS SELECT id, name, description, image, created_at, modified_at FROM province');
        $this->addSql('DROP TABLE province');
        $this->addSql('CREATE TABLE province (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, image VARCHAR(511) DEFAULT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , modified_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO province (id, name, description, image, created_at, modified_at) SELECT id, name, description, image, created_at, modified_at FROM __temp__province');
        $this->addSql('DROP TABLE __temp__province');
        $this->addSql('CREATE TEMPORARY TABLE __temp__race AS SELECT id, homeland_id, name, created_at, modified_at, description, image FROM race');
        $this->addSql('DROP TABLE race');
        $this->addSql('CREATE TABLE race (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, homeland_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , modified_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , description CLOB DEFAULT NULL, image VARCHAR(511) DEFAULT NULL, CONSTRAINT FK_DA6FBBAF10A31E74 FOREIGN KEY (homeland_id) REFERENCES province (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO race (id, homeland_id, name, created_at, modified_at, description, image) SELECT id, homeland_id, name, created_at, modified_at, description, image FROM __temp__race');
        $this->addSql('DROP TABLE __temp__race');
        $this->addSql('CREATE INDEX IDX_DA6FBBAF10A31E74 ON race (homeland_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__skill AS SELECT id, name, created_at, modified_at, image FROM skill');
        $this->addSql('DROP TABLE skill');
        $this->addSql('CREATE TABLE skill (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , modified_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , image VARCHAR(511) DEFAULT NULL)');
        $this->addSql('INSERT INTO skill (id, name, created_at, modified_at, image) SELECT id, name, created_at, modified_at, image FROM __temp__skill');
        $this->addSql('DROP TABLE __temp__skill');
    }
}
