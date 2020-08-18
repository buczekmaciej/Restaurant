<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200818112004 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employees (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, login VARCHAR(35) NOT NULL, password VARCHAR(20) NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE ingredients (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE meals (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE INDEX IDX_E229E6EAC54C8C93 ON meals (type_id)');
        $this->addSql('CREATE TABLE meals_ingredients (meals_id INTEGER NOT NULL, ingredients_id INTEGER NOT NULL, PRIMARY KEY(meals_id, ingredients_id))');
        $this->addSql('CREATE INDEX IDX_DF77A0AB88A25CA2 ON meals_ingredients (meals_id)');
        $this->addSql('CREATE INDEX IDX_DF77A0AB3EC4DCE ON meals_ingredients (ingredients_id)');
        $this->addSql('CREATE TABLE orders (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, create_at DATETIME NOT NULL, address VARCHAR(500) NOT NULL, order_list CLOB NOT NULL --(DC2Type:array)
        , status VARCHAR(25) NOT NULL)');
        $this->addSql('CREATE TABLE type (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('DROP TABLE migration_versions');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE migration_versions (version VARCHAR(14) NOT NULL COLLATE BINARY, executed_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , PRIMARY KEY(version))');
        $this->addSql('DROP TABLE employees');
        $this->addSql('DROP TABLE ingredients');
        $this->addSql('DROP TABLE meals');
        $this->addSql('DROP TABLE meals_ingredients');
        $this->addSql('DROP TABLE orders');
        $this->addSql('DROP TABLE type');
    }
}
