<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190906104348 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE post_attachement (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) DEFAULT NULL, alt VARCHAR(100) DEFAULT NULL, path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE post ADD attachement_id INT DEFAULT NULL, DROP attachement');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA05591E0 FOREIGN KEY (attachement_id) REFERENCES post_attachement (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A8A6C8DA05591E0 ON post (attachement_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA05591E0');
        $this->addSql('DROP TABLE post_attachement');
        $this->addSql('DROP INDEX UNIQ_5A8A6C8DA05591E0 ON post');
        $this->addSql('ALTER TABLE post ADD attachement VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP attachement_id');
    }
}
