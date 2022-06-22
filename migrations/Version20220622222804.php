<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220622222804 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE complement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prix DOUBLE PRECISION NOT NULL, image LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:object)\', etat TINYINT(1) NOT NULL, type VARCHAR(50) DEFAULT NULL, taille VARCHAR(50) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, prix DOUBLE PRECISION NOT NULL, nom VARCHAR(50) NOT NULL, image LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:object)\', etat TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user DROP is_enable');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE complement');
        $this->addSql('DROP TABLE menu');
        $this->addSql('ALTER TABLE user ADD is_enable TINYINT(1) NOT NULL');
    }
}
