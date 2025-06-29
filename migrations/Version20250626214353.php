<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250626214353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE fish_species (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, protection_start DATE NOT NULL, protection_end DATE NOT NULL, daily_limit INT NOT NULL, min_length NUMERIC(5, 2) NOT NULL, PRIMARY KEY(id))
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE fish ADD CONSTRAINT FK_3F744433B2A1D860 FOREIGN KEY (species_id) REFERENCES fish_species (id) NOT DEFERRABLE INITIALLY IMMEDIATE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_3F744433B2A1D860 ON fish (species_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE SCHEMA public
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE fish DROP CONSTRAINT FK_3F744433B2A1D860
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE fish_species
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_3F744433B2A1D860
        SQL);
    }
}
