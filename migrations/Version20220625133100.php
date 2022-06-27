<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220625133100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD gestionnaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404556885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
        $this->addSql('CREATE INDEX IDX_C74404556885AC1B ON client (gestionnaire_id)');
        $this->addSql('ALTER TABLE livreur ADD gestionnaire_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livreur ADD CONSTRAINT FK_EB7A4E6D6885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
        $this->addSql('CREATE INDEX IDX_EB7A4E6D6885AC1B ON livreur (gestionnaire_id)');
        $this->addSql('ALTER TABLE produit ADD gestionnaire_id INT DEFAULT NULL, ADD menu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC276885AC1B FOREIGN KEY (gestionnaire_id) REFERENCES gestionnaire (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC276885AC1B ON produit (gestionnaire_id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27CCD7E912 ON produit (menu_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404556885AC1B');
        $this->addSql('DROP INDEX IDX_C74404556885AC1B ON client');
        $this->addSql('ALTER TABLE client DROP gestionnaire_id');
        $this->addSql('ALTER TABLE livreur DROP FOREIGN KEY FK_EB7A4E6D6885AC1B');
        $this->addSql('DROP INDEX IDX_EB7A4E6D6885AC1B ON livreur');
        $this->addSql('ALTER TABLE livreur DROP gestionnaire_id');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC276885AC1B');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27CCD7E912');
        $this->addSql('DROP INDEX IDX_29A5EC276885AC1B ON produit');
        $this->addSql('DROP INDEX IDX_29A5EC27CCD7E912 ON produit');
        $this->addSql('ALTER TABLE produit DROP gestionnaire_id, DROP menu_id');
    }
}
