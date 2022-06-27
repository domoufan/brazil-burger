<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220626213449 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX mat_moto ON livreur');
        $this->addSql('ALTER TABLE livreur CHANGE matMoto mat_moto VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE menu ADD type VARCHAR(50) DEFAULT NULL, ADD description VARCHAR(255) DEFAULT NULL, CHANGE gestionnaire_id gestionnaire_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livreur CHANGE mat_moto matMoto VARCHAR(50) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX mat_moto ON livreur (matMoto)');
        $this->addSql('ALTER TABLE menu DROP type, DROP description, CHANGE gestionnaire_id gestionnaire_id INT NOT NULL');
    }
}
