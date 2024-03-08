<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240308102957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE access_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(12) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE composter (id INT AUTO_INCREMENT NOT NULL, owner_type_id INT NOT NULL, access_type_id INT NOT NULL, fill_rate_id INT DEFAULT NULL, longitude DOUBLE PRECISION NOT NULL, latitude DOUBLE PRECISION NOT NULL, contact VARCHAR(255) NOT NULL, INDEX IDX_FCFE9BAC493A0A4C (owner_type_id), INDEX IDX_FCFE9BACD695686 (access_type_id), INDEX IDX_FCFE9BAC4B5C90FF (fill_rate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fill_rate_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, pourcentage INT NOT NULL, color VARCHAR(16) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE opening_date (id INT AUTO_INCREMENT NOT NULL, day VARCHAR(24) NOT NULL, opening_time TIME NOT NULL, closure_time TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE owner_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(124) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, author_user_id INT NOT NULL, responsable_user_id INT DEFAULT NULL, composter_id INT NOT NULL, title VARCHAR(256) NOT NULL, description VARCHAR(500) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', closed_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', statut VARCHAR(16) NOT NULL, INDEX IDX_97A0ADA3E2544CD6 (author_user_id), INDEX IDX_97A0ADA3BBA16F66 (responsable_user_id), INDEX IDX_97A0ADA37E93ED02 (composter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE composter ADD CONSTRAINT FK_FCFE9BAC493A0A4C FOREIGN KEY (owner_type_id) REFERENCES owner_type (id)');
        $this->addSql('ALTER TABLE composter ADD CONSTRAINT FK_FCFE9BACD695686 FOREIGN KEY (access_type_id) REFERENCES access_type (id)');
        $this->addSql('ALTER TABLE composter ADD CONSTRAINT FK_FCFE9BAC4B5C90FF FOREIGN KEY (fill_rate_id) REFERENCES fill_rate_type (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3E2544CD6 FOREIGN KEY (author_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3BBA16F66 FOREIGN KEY (responsable_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA37E93ED02 FOREIGN KEY (composter_id) REFERENCES composter (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE composter DROP FOREIGN KEY FK_FCFE9BAC493A0A4C');
        $this->addSql('ALTER TABLE composter DROP FOREIGN KEY FK_FCFE9BACD695686');
        $this->addSql('ALTER TABLE composter DROP FOREIGN KEY FK_FCFE9BAC4B5C90FF');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3E2544CD6');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3BBA16F66');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA37E93ED02');
        $this->addSql('DROP TABLE access_type');
        $this->addSql('DROP TABLE composter');
        $this->addSql('DROP TABLE fill_rate_type');
        $this->addSql('DROP TABLE opening_date');
        $this->addSql('DROP TABLE owner_type');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_type');
    }
}
