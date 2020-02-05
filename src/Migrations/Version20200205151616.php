<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200205151616 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE aficiones (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(20) NOT NULL)');
        $this->addSql('CREATE TABLE ciudades (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(40) NOT NULL)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('CREATE TABLE usuarios (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nombre VARCHAR(30) NOT NULL, apellidos VARCHAR(30) NOT NULL, nacimiento DATE NOT NULL, sexo VARCHAR(2) NOT NULL, ciudad_id INTEGER DEFAULT NULL)');
        $this->addSql('CREATE TABLE usuarios_aficiones (usuarios_id INTEGER NOT NULL, aficiones_id INTEGER NOT NULL, PRIMARY KEY(usuarios_id, aficiones_id))');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE aficiones');
        $this->addSql('DROP TABLE ciudades');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE usuarios');
        $this->addSql('DROP TABLE usuarios_aficiones');
    }
}
