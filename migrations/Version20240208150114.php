<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240208150114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE access_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE composter (id INT AUTO_INCREMENT NOT NULL, owner_type_id INT NOT NULL, access_type_id INT NOT NULL, fill_rate_type_id INT DEFAULT NULL, latitude DOUBLE PRECISION NOT NULL, longitude DOUBLE PRECISION NOT NULL, INDEX IDX_FCFE9BAC493A0A4C (owner_type_id), INDEX IDX_FCFE9BACD695686 (access_type_id), INDEX IDX_FCFE9BAC124687B8 (fill_rate_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE composter_day (id INT AUTO_INCREMENT NOT NULL, composter_id INT NOT NULL, day_id INT NOT NULL, opening_time TIME NOT NULL, closure_time TIME NOT NULL, INDEX IDX_6004B3C27E93ED02 (composter_id), INDEX IDX_6004B3C29C24126 (day_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE day (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fill_rate_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, pourcentage INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE owner_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, responsable_id INT DEFAULT NULL, composter_id INT NOT NULL, statut_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', closed_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_97A0ADA3F675F31B (author_id), INDEX IDX_97A0ADA353C59D72 (responsable_id), INDEX IDX_97A0ADA37E93ED02 (composter_id), INDEX IDX_97A0ADA3F6203804 (statut_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket_statut_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, firstname VARCHAR(64) NOT NULL, lastname VARCHAR(64) NOT NULL, pseudo VARCHAR(64) DEFAULT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_8D93D649C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE composter ADD CONSTRAINT FK_FCFE9BAC493A0A4C FOREIGN KEY (owner_type_id) REFERENCES owner_type (id)');
        $this->addSql('ALTER TABLE composter ADD CONSTRAINT FK_FCFE9BACD695686 FOREIGN KEY (access_type_id) REFERENCES access_type (id)');
        $this->addSql('ALTER TABLE composter ADD CONSTRAINT FK_FCFE9BAC124687B8 FOREIGN KEY (fill_rate_type_id) REFERENCES fill_rate_type (id)');
        $this->addSql('ALTER TABLE composter_day ADD CONSTRAINT FK_6004B3C27E93ED02 FOREIGN KEY (composter_id) REFERENCES composter (id)');
        $this->addSql('ALTER TABLE composter_day ADD CONSTRAINT FK_6004B3C29C24126 FOREIGN KEY (day_id) REFERENCES day (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA353C59D72 FOREIGN KEY (responsable_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA37E93ED02 FOREIGN KEY (composter_id) REFERENCES composter (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3F6203804 FOREIGN KEY (statut_id) REFERENCES ticket_statut_type (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649C54C8C93 FOREIGN KEY (type_id) REFERENCES user_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE composter DROP FOREIGN KEY FK_FCFE9BAC493A0A4C');
        $this->addSql('ALTER TABLE composter DROP FOREIGN KEY FK_FCFE9BACD695686');
        $this->addSql('ALTER TABLE composter DROP FOREIGN KEY FK_FCFE9BAC124687B8');
        $this->addSql('ALTER TABLE composter_day DROP FOREIGN KEY FK_6004B3C27E93ED02');
        $this->addSql('ALTER TABLE composter_day DROP FOREIGN KEY FK_6004B3C29C24126');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3F675F31B');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA353C59D72');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA37E93ED02');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3F6203804');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649C54C8C93');
        $this->addSql('DROP TABLE access_type');
        $this->addSql('DROP TABLE composter');
        $this->addSql('DROP TABLE composter_day');
        $this->addSql('DROP TABLE day');
        $this->addSql('DROP TABLE fill_rate_type');
        $this->addSql('DROP TABLE owner_type');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE ticket_statut_type');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_type');
    }
}
