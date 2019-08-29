<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190828110721 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player CHANGE strong_feets strong_feets LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE postes postes LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', CHANGE current_club current_club VARCHAR(255) DEFAULT NULL, CHANGE status status VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player CHANGE strong_feets strong_feets LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', CHANGE postes postes LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:array)\', CHANGE current_club current_club VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE status status VARCHAR(100) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
