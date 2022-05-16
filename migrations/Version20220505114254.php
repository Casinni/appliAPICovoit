<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220505114254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE trajet_personne');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98C97A9E2C6');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98CBFADF06C');
        $this->addSql('DROP INDEX UNIQ_2B5BA98CBFADF06C ON trajet');
        $this->addSql('DROP INDEX UNIQ_2B5BA98C97A9E2C6 ON trajet');
        $this->addSql('ALTER TABLE trajet ADD ville_id INT DEFAULT NULL, ADD pers_id INT DEFAULT NULL, DROP ville_dep_id, DROP ville_arr_id');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CA73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98C4AA53143 FOREIGN KEY (pers_id) REFERENCES personne (id)');
        $this->addSql('CREATE INDEX IDX_2B5BA98CA73F0036 ON trajet (ville_id)');
        $this->addSql('CREATE INDEX IDX_2B5BA98C4AA53143 ON trajet (pers_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trajet_personne (trajet_id INT NOT NULL, personne_id INT NOT NULL, INDEX IDX_58D4CBCBD12A823 (trajet_id), INDEX IDX_58D4CBCBA21BD112 (personne_id), PRIMARY KEY(trajet_id, personne_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE trajet_personne ADD CONSTRAINT FK_58D4CBCBA21BD112 FOREIGN KEY (personne_id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trajet_personne ADD CONSTRAINT FK_58D4CBCBD12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE marque CHANGE nom nom VARCHAR(50) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE personne CHANGE nom nom VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prenom prenom VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE tel tel VARCHAR(10) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98CA73F0036');
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98C4AA53143');
        $this->addSql('DROP INDEX IDX_2B5BA98CA73F0036 ON trajet');
        $this->addSql('DROP INDEX IDX_2B5BA98C4AA53143 ON trajet');
        $this->addSql('ALTER TABLE trajet ADD ville_dep_id INT DEFAULT NULL, ADD ville_arr_id INT DEFAULT NULL, DROP ville_id, DROP pers_id');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98C97A9E2C6 FOREIGN KEY (ville_dep_id) REFERENCES ville (id)');
        $this->addSql('ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98CBFADF06C FOREIGN KEY (ville_arr_id) REFERENCES ville (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2B5BA98CBFADF06C ON trajet (ville_arr_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2B5BA98C97A9E2C6 ON trajet (ville_dep_id)');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE api_token api_token VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE ville CHANGE ville ville VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE voiture CHANGE modele modele VARCHAR(30) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
