<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250724145858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE entrainements (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date_entrainement DATETIME NOT NULL, duree_minutes INTEGER DEFAULT NULL, notes_entrainement CLOB DEFAULT NULL, date_creation DATETIME NOT NULL, date_mise_ajour DATETIME NOT NULL, seance_id INTEGER DEFAULT NULL, programme_id INTEGER DEFAULT NULL, utilisateur_id INTEGER NOT NULL, CONSTRAINT FK_CBCCADB8E3797A94 FOREIGN KEY (seance_id) REFERENCES seances (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CBCCADB862BB7AEE FOREIGN KEY (programme_id) REFERENCES programmes (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CBCCADB8FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_CBCCADB8E3797A94 ON entrainements (seance_id)');
        $this->addSql('CREATE INDEX IDX_CBCCADB862BB7AEE ON entrainements (programme_id)');
        $this->addSql('CREATE INDEX IDX_CBCCADB8FB88E14F ON entrainements (utilisateur_id)');
        $this->addSql('CREATE TABLE exercices (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom_exercice VARCHAR(255) NOT NULL, description_exercice CLOB DEFAULT NULL, type_exercice VARCHAR(100) NOT NULL, date_creation DATETIME NOT NULL, date_mise_ajour DATETIME NOT NULL)');
        $this->addSql('CREATE TABLE programmes (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom_programme VARCHAR(255) NOT NULL, description_programme CLOB DEFAULT NULL, date_creation DATETIME NOT NULL, date_mise_ajour DATETIME NOT NULL, utilisateur_id INTEGER NOT NULL, CONSTRAINT FK_3631FC3FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_3631FC3FFB88E14F ON programmes (utilisateur_id)');
        $this->addSql('CREATE TABLE seance_exercices (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, ordre_affichage INTEGER NOT NULL, repetitions INTEGER DEFAULT NULL, series INTEGER DEFAULT NULL, duree_minutes INTEGER DEFAULT NULL, seance_id INTEGER NOT NULL, exercice_id INTEGER NOT NULL, CONSTRAINT FK_4DB5A86FE3797A94 FOREIGN KEY (seance_id) REFERENCES seances (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4DB5A86F89D40298 FOREIGN KEY (exercice_id) REFERENCES exercices (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_4DB5A86FE3797A94 ON seance_exercices (seance_id)');
        $this->addSql('CREATE INDEX IDX_4DB5A86F89D40298 ON seance_exercices (exercice_id)');
        $this->addSql('CREATE TABLE seances (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom_seance VARCHAR(255) NOT NULL, description_seance CLOB DEFAULT NULL, date_creation DATETIME NOT NULL, date_mise_ajour DATETIME NOT NULL, programme_id INTEGER NOT NULL, CONSTRAINT FK_FC699FF162BB7AEE FOREIGN KEY (programme_id) REFERENCES programmes (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_FC699FF162BB7AEE ON seances (programme_id)');
        $this->addSql('CREATE TABLE themes (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom_theme VARCHAR(255) NOT NULL, description_theme CLOB DEFAULT NULL)');
        $this->addSql('CREATE TABLE utilisateurs (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom_utilisateur VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, mot_de_passe_hache VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, date_mise_ajour DATETIME NOT NULL, roles CLOB NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_497B315ED37CC8AC ON utilisateurs (nom_utilisateur)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_497B315EE7927C74 ON utilisateurs (email)');
        $this->addSql('CREATE TABLE utilisateur_themes (utilisateur_id INTEGER NOT NULL, theme_id INTEGER NOT NULL, PRIMARY KEY (utilisateur_id, theme_id), CONSTRAINT FK_74EF0855FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_74EF085559027487 FOREIGN KEY (theme_id) REFERENCES themes (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_74EF0855FB88E14F ON utilisateur_themes (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_74EF085559027487 ON utilisateur_themes (theme_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE entrainements');
        $this->addSql('DROP TABLE exercices');
        $this->addSql('DROP TABLE programmes');
        $this->addSql('DROP TABLE seance_exercices');
        $this->addSql('DROP TABLE seances');
        $this->addSql('DROP TABLE themes');
        $this->addSql('DROP TABLE utilisateurs');
        $this->addSql('DROP TABLE utilisateur_themes');
    }
}
