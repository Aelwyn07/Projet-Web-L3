<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260319103219 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "proj_cart" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, quantity INTEGER NOT NULL, id_user_id INTEGER NOT NULL, id_product_id INTEGER NOT NULL, CONSTRAINT FK_BCEA5E1779F37AE5 FOREIGN KEY (id_user_id) REFERENCES "proj_user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_BCEA5E17E00EE68D FOREIGN KEY (id_product_id) REFERENCES "proj_product" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BCEA5E1779F37AE5 ON "proj_cart" (id_user_id)');
        $this->addSql('CREATE INDEX IDX_BCEA5E17E00EE68D ON "proj_cart" (id_product_id)');
        $this->addSql('CREATE TABLE "proj_country" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, code VARCHAR(5) NOT NULL)');
        $this->addSql('CREATE TABLE "proj_country_product" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, stock INTEGER NOT NULL, id_product_id INTEGER NOT NULL, id_country_id INTEGER NOT NULL, CONSTRAINT FK_17767364E00EE68D FOREIGN KEY (id_product_id) REFERENCES "proj_product" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_177673645CA5BEA7 FOREIGN KEY (id_country_id) REFERENCES "proj_country" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_17767364E00EE68D ON "proj_country_product" (id_product_id)');
        $this->addSql('CREATE INDEX IDX_177673645CA5BEA7 ON "proj_country_product" (id_country_id)');
        $this->addSql('CREATE TABLE "proj_product" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, label VARCHAR(255) NOT NULL, unit_price DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE TABLE "proj_user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles CLOB NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(100) NOT NULL, surname VARCHAR(100) NOT NULL, birth_date DATE NOT NULL, id_country_id INTEGER NOT NULL, CONSTRAINT FK_3ADA00E95CA5BEA7 FOREIGN KEY (id_country_id) REFERENCES "proj_country" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3ADA00E95CA5BEA7 ON "proj_user" (id_country_id)');
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
