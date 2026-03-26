<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260324140055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__proj_country_product AS SELECT id, product_id, country_id FROM proj_country_product');
        $this->addSql('DROP TABLE proj_country_product');
        $this->addSql('CREATE TABLE proj_country_product (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, product_id INTEGER NOT NULL, country_id INTEGER NOT NULL, CONSTRAINT FK_177673644584665A FOREIGN KEY (product_id) REFERENCES proj_product (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_17767364F92F3E70 FOREIGN KEY (country_id) REFERENCES proj_country (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO proj_country_product (id, product_id, country_id) SELECT id, product_id, country_id FROM __temp__proj_country_product');
        $this->addSql('DROP TABLE __temp__proj_country_product');
        $this->addSql('CREATE INDEX IDX_17767364F92F3E70 ON proj_country_product (country_id)');
        $this->addSql('CREATE INDEX IDX_177673644584665A ON proj_country_product (product_id)');
        $this->addSql('ALTER TABLE proj_product ADD COLUMN stock INTEGER NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "proj_country_product" ADD COLUMN stock INTEGER NOT NULL');
        $this->addSql('CREATE TEMPORARY TABLE __temp__proj_product AS SELECT id, label, unit_price FROM "proj_product"');
        $this->addSql('DROP TABLE "proj_product"');
        $this->addSql('CREATE TABLE "proj_product" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, label VARCHAR(255) NOT NULL, unit_price DOUBLE PRECISION NOT NULL)');
        $this->addSql('INSERT INTO "proj_product" (id, label, unit_price) SELECT id, label, unit_price FROM __temp__proj_product');
        $this->addSql('DROP TABLE __temp__proj_product');
    }
}
