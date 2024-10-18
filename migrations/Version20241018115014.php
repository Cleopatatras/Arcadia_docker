<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241018115014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animaux (id INT AUTO_INCREMENT NOT NULL, habitat_id INT NOT NULL, nom VARCHAR(100) NOT NULL, race VARCHAR(150) NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_9ABE194DAFFE2D26 (habitat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE compte_rendu (id INT AUTO_INCREMENT NOT NULL, animal_id INT NOT NULL, user_id INT NOT NULL, nourriture_id INT NOT NULL, date DATE NOT NULL, etat_animal LONGTEXT NOT NULL, grammage DOUBLE PRECISION NOT NULL, detail LONGTEXT DEFAULT NULL, INDEX IDX_D39E69D28E962C16 (animal_id), INDEX IDX_D39E69D2A76ED395 (user_id), INDEX IDX_D39E69D298BD5834 (nourriture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE habitats (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, animal_id INT DEFAULT NULL, habitat_id INT DEFAULT NULL, service_id INT DEFAULT NULL, link_image VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_E01FBE6A8E962C16 (animal_id), INDEX IDX_E01FBE6AAFFE2D26 (habitat_id), INDEX IDX_E01FBE6AED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nourriture (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE services (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(100) NOT NULL, prenom VARCHAR(100) NOT NULL, email VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animaux ADD CONSTRAINT FK_9ABE194DAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitats (id)');
        $this->addSql('ALTER TABLE compte_rendu ADD CONSTRAINT FK_D39E69D28E962C16 FOREIGN KEY (animal_id) REFERENCES animaux (id)');
        $this->addSql('ALTER TABLE compte_rendu ADD CONSTRAINT FK_D39E69D2A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE compte_rendu ADD CONSTRAINT FK_D39E69D298BD5834 FOREIGN KEY (nourriture_id) REFERENCES nourriture (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A8E962C16 FOREIGN KEY (animal_id) REFERENCES animaux (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitats (id)');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6AED5CA9E6 FOREIGN KEY (service_id) REFERENCES services (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animaux DROP FOREIGN KEY FK_9ABE194DAFFE2D26');
        $this->addSql('ALTER TABLE compte_rendu DROP FOREIGN KEY FK_D39E69D28E962C16');
        $this->addSql('ALTER TABLE compte_rendu DROP FOREIGN KEY FK_D39E69D2A76ED395');
        $this->addSql('ALTER TABLE compte_rendu DROP FOREIGN KEY FK_D39E69D298BD5834');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A8E962C16');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AAFFE2D26');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6AED5CA9E6');
        $this->addSql('DROP TABLE animaux');
        $this->addSql('DROP TABLE compte_rendu');
        $this->addSql('DROP TABLE habitats');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE nourriture');
        $this->addSql('DROP TABLE services');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
