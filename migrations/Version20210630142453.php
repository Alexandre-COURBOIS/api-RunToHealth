<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210630142453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE characteristics (id INT AUTO_INCREMENT NOT NULL, weight_id INT DEFAULT NULL, height INT NOT NULL, smoker TINYINT(1) NOT NULL, alcohol TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_7037B156350035DC (weight_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objective_alcohol (id INT AUTO_INCREMENT NOT NULL, objective_id INT DEFAULT NULL, drink TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_3EEA32F073484933 (objective_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objective_smoker (id INT AUTO_INCREMENT NOT NULL, objective_id INT DEFAULT NULL, number INT NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_6326D47D73484933 (objective_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objective_sport (id INT AUTO_INCREMENT NOT NULL, objective_id INT DEFAULT NULL, time DATETIME NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_7C11D2E173484933 (objective_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objective_weight (id INT AUTO_INCREMENT NOT NULL, objective_id INT DEFAULT NULL, number INT NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_B87BA06A73484933 (objective_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE objectives (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, begin_at DATETIME NOT NULL, end_at DATETIME NOT NULL, sucess TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, INDEX IDX_6CB0696CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE refresh_tokens (id INT AUTO_INCREMENT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid DATETIME NOT NULL, UNIQUE INDEX UNIQ_9BACE7E1C74F2195 (refresh_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, characteristics_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, city VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, postal_code INT NOT NULL, phone INT NOT NULL, longitude DOUBLE PRECISION DEFAULT NULL, latitude DOUBLE PRECISION DEFAULT NULL, password VARCHAR(255) NOT NULL, token VARCHAR(255) NOT NULL, reset_token VARCHAR(255) DEFAULT NULL, active TINYINT(1) NOT NULL, active_since DATETIME DEFAULT NULL, inactive_since DATETIME DEFAULT NULL, roles JSON NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), UNIQUE INDEX UNIQ_1483A5E94B13ADB4 (characteristics_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE weight (id INT AUTO_INCREMENT NOT NULL, weight DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE characteristics ADD CONSTRAINT FK_7037B156350035DC FOREIGN KEY (weight_id) REFERENCES weight (id)');
        $this->addSql('ALTER TABLE objective_alcohol ADD CONSTRAINT FK_3EEA32F073484933 FOREIGN KEY (objective_id) REFERENCES objectives (id)');
        $this->addSql('ALTER TABLE objective_smoker ADD CONSTRAINT FK_6326D47D73484933 FOREIGN KEY (objective_id) REFERENCES objectives (id)');
        $this->addSql('ALTER TABLE objective_sport ADD CONSTRAINT FK_7C11D2E173484933 FOREIGN KEY (objective_id) REFERENCES objectives (id)');
        $this->addSql('ALTER TABLE objective_weight ADD CONSTRAINT FK_B87BA06A73484933 FOREIGN KEY (objective_id) REFERENCES objectives (id)');
        $this->addSql('ALTER TABLE objectives ADD CONSTRAINT FK_6CB0696CA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E94B13ADB4 FOREIGN KEY (characteristics_id) REFERENCES characteristics (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E94B13ADB4');
        $this->addSql('ALTER TABLE objective_alcohol DROP FOREIGN KEY FK_3EEA32F073484933');
        $this->addSql('ALTER TABLE objective_smoker DROP FOREIGN KEY FK_6326D47D73484933');
        $this->addSql('ALTER TABLE objective_sport DROP FOREIGN KEY FK_7C11D2E173484933');
        $this->addSql('ALTER TABLE objective_weight DROP FOREIGN KEY FK_B87BA06A73484933');
        $this->addSql('ALTER TABLE objectives DROP FOREIGN KEY FK_6CB0696CA76ED395');
        $this->addSql('ALTER TABLE characteristics DROP FOREIGN KEY FK_7037B156350035DC');
        $this->addSql('DROP TABLE characteristics');
        $this->addSql('DROP TABLE objective_alcohol');
        $this->addSql('DROP TABLE objective_smoker');
        $this->addSql('DROP TABLE objective_sport');
        $this->addSql('DROP TABLE objective_weight');
        $this->addSql('DROP TABLE objectives');
        $this->addSql('DROP TABLE refresh_tokens');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE weight');
    }
}
