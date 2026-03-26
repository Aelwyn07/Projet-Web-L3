<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260323105100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "proj_cart" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, quantity INTEGER NOT NULL, user_id INTEGER NOT NULL, product_id INTEGER NOT NULL, CONSTRAINT FK_BCEA5E17A76ED395 FOREIGN KEY (user_id) REFERENCES "proj_user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_BCEA5E174584665A FOREIGN KEY (product_id) REFERENCES "proj_product" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_BCEA5E17A76ED395 ON "proj_cart" (user_id)');
        $this->addSql('CREATE INDEX IDX_BCEA5E174584665A ON "proj_cart" (product_id)');
        $this->addSql('CREATE TABLE "proj_country" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, code VARCHAR(5) NOT NULL)');
        $this->addSql('CREATE TABLE "proj_country_product" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, stock INTEGER NOT NULL, product_id INTEGER NOT NULL, country_id INTEGER NOT NULL, CONSTRAINT FK_177673644584665A FOREIGN KEY (product_id) REFERENCES "proj_product" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_17767364F92F3E70 FOREIGN KEY (country_id) REFERENCES "proj_country" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_177673644584665A ON "proj_country_product" (product_id)');
        $this->addSql('CREATE INDEX IDX_17767364F92F3E70 ON "proj_country_product" (country_id)');
        $this->addSql('CREATE TABLE "proj_product" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, label VARCHAR(255) NOT NULL, unit_price DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE TABLE "proj_user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles CLOB NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(100) NOT NULL, surname VARCHAR(100) NOT NULL, birth_date DATE NOT NULL, country_id INTEGER NOT NULL, CONSTRAINT FK_3ADA00E9F92F3E70 FOREIGN KEY (country_id) REFERENCES "proj_country" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3ADA00E9F92F3E70 ON "proj_user" (country_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_LOGIN ON "proj_user" (login)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE "proj_cart"');
        $this->addSql('DROP TABLE "proj_country"');
        $this->addSql('DROP TABLE "proj_country_product"');
        $this->addSql('DROP TABLE "proj_product"');
        $this->addSql('DROP TABLE "proj_user"');
    }
}
