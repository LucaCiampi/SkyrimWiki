<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221106153724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE race_skill (race_id INTEGER NOT NULL, skill_id INTEGER NOT NULL, PRIMARY KEY(race_id, skill_id), CONSTRAINT FK_B803C5666E59D40D FOREIGN KEY (race_id) REFERENCES race (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B803C5665585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B803C5666E59D40D ON race_skill (race_id)');
        $this->addSql('CREATE INDEX IDX_B803C5665585C142 ON race_skill (skill_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__skill AS SELECT id, name, created_at, modified_at FROM skill');
        $this->addSql('DROP TABLE skill');
        $this->addSql('CREATE TABLE skill (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , modified_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO skill (id, name, created_at, modified_at) SELECT id, name, created_at, modified_at FROM __temp__skill');
        $this->addSql('DROP TABLE __temp__skill');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE race_skill');
        $this->addSql('CREATE TEMPORARY TABLE __temp__skill AS SELECT id, name, created_at, modified_at FROM skill');
        $this->addSql('DROP TABLE skill');
        $this->addSql('CREATE TABLE skill (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, modified_at DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO skill (id, name, created_at, modified_at) SELECT id, name, created_at, modified_at FROM __temp__skill');
        $this->addSql('DROP TABLE __temp__skill');
    }
}
