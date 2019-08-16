<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190816095656 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_DF77A0AB3EC4DCE');
        $this->addSql('DROP INDEX IDX_DF77A0AB88A25CA2');
        $this->addSql('CREATE TEMPORARY TABLE __temp__meals_ingredients AS SELECT meals_id, ingredients_id FROM meals_ingredients');
        $this->addSql('DROP TABLE meals_ingredients');
        $this->addSql('CREATE TABLE meals_ingredients (meals_id INTEGER NOT NULL, ingredients_id INTEGER NOT NULL, PRIMARY KEY(meals_id, ingredients_id), CONSTRAINT FK_DF77A0AB88A25CA2 FOREIGN KEY (meals_id) REFERENCES meals (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_DF77A0AB3EC4DCE FOREIGN KEY (ingredients_id) REFERENCES ingredients (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO meals_ingredients (meals_id, ingredients_id) SELECT meals_id, ingredients_id FROM __temp__meals_ingredients');
        $this->addSql('DROP TABLE __temp__meals_ingredients');
        $this->addSql('CREATE INDEX IDX_DF77A0AB3EC4DCE ON meals_ingredients (ingredients_id)');
        $this->addSql('CREATE INDEX IDX_DF77A0AB88A25CA2 ON meals_ingredients (meals_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__orders AS SELECT id, create_at, address, order_list, status FROM orders');
        $this->addSql('DROP TABLE orders');
        $this->addSql('CREATE TABLE orders (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, create_at DATETIME NOT NULL, address VARCHAR(500) NOT NULL COLLATE BINARY, order_list CLOB NOT NULL COLLATE BINARY --(DC2Type:array)
        , status VARCHAR(25) NOT NULL)');
        $this->addSql('INSERT INTO orders (id, create_at, address, order_list, status) SELECT id, create_at, address, order_list, status FROM __temp__orders');
        $this->addSql('DROP TABLE __temp__orders');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_DF77A0AB88A25CA2');
        $this->addSql('DROP INDEX IDX_DF77A0AB3EC4DCE');
        $this->addSql('CREATE TEMPORARY TABLE __temp__meals_ingredients AS SELECT meals_id, ingredients_id FROM meals_ingredients');
        $this->addSql('DROP TABLE meals_ingredients');
        $this->addSql('CREATE TABLE meals_ingredients (meals_id INTEGER NOT NULL, ingredients_id INTEGER NOT NULL, PRIMARY KEY(meals_id, ingredients_id))');
        $this->addSql('INSERT INTO meals_ingredients (meals_id, ingredients_id) SELECT meals_id, ingredients_id FROM __temp__meals_ingredients');
        $this->addSql('DROP TABLE __temp__meals_ingredients');
        $this->addSql('CREATE INDEX IDX_DF77A0AB88A25CA2 ON meals_ingredients (meals_id)');
        $this->addSql('CREATE INDEX IDX_DF77A0AB3EC4DCE ON meals_ingredients (ingredients_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__orders AS SELECT id, create_at, address, order_list, status FROM orders');
        $this->addSql('DROP TABLE orders');
        $this->addSql('CREATE TABLE orders (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, create_at DATETIME NOT NULL, address VARCHAR(500) NOT NULL, order_list CLOB NOT NULL --(DC2Type:array)
        , status VARCHAR(25) DEFAULT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO orders (id, create_at, address, order_list, status) SELECT id, create_at, address, order_list, status FROM __temp__orders');
        $this->addSql('DROP TABLE __temp__orders');
    }
}
