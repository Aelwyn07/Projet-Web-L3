<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260323160931 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE proj_country ADD COLUMN name VARCHAR(150) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__proj_country AS SELECT id, code FROM "proj_country"');
        $this->addSql('DROP TABLE "proj_country"');
        $this->addSql('CREATE TABLE "proj_country" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, code VARCHAR(5) NOT NULL)');
        $this->addSql('INSERT INTO "proj_country" (id, code) SELECT id, code FROM __temp__proj_country');
        $this->addSql('DROP TABLE __temp__proj_country');
    }
}
