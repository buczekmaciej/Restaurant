<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190813083132 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE employees (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, login VARCHAR(35) NOT NULL, password VARCHAR(20) NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE ingredients (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE meals (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, type VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE meals_ingredients (meals_id INTEGER NOT NULL, ingredients_id INTEGER NOT NULL, PRIMARY KEY(meals_id, ingredients_id))');
        $this->addSql('CREATE INDEX IDX_DF77A0AB88A25CA2 ON meals_ingredients (meals_id)');
        $this->addSql('CREATE INDEX IDX_DF77A0AB3EC4DCE ON meals_ingredients (ingredients_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE employees');
        $this->addSql('DROP TABLE ingredients');
        $this->addSql('DROP TABLE meals');
        $this->addSql('DROP TABLE meals_ingredients');
    }
}
