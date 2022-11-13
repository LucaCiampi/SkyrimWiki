<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221113100213 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE follower ADD COLUMN biography CLOB DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__follower AS SELECT id, race_id, living_in_id, name, created_at, modified_at, image FROM follower');
        $this->addSql('DROP TABLE follower');
        $this->addSql('CREATE TABLE follower (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, race_id INTEGER NOT NULL, living_in_id INTEGER DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , modified_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        , image VARCHAR(511) DEFAULT NULL, CONSTRAINT FK_B9D609466E59D40D FOREIGN KEY (race_id) REFERENCES race (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B9D60946D6F07E95 FOREIGN KEY (living_in_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO follower (id, race_id, living_in_id, name, created_at, modified_at, image) SELECT id, race_id, living_in_id, name, created_at, modified_at, image FROM __temp__follower');
        $this->addSql('DROP TABLE __temp__follower');
        $this->addSql('CREATE INDEX IDX_B9D609466E59D40D ON follower (race_id)');
        $this->addSql('CREATE INDEX IDX_B9D60946D6F07E95 ON follower (living_in_id)');
    }
}
