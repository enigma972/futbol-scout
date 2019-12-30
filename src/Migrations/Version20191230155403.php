<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191230155403 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player ADD current_club_id INT NOT NULL, DROP current_club');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65CB148FB7 FOREIGN KEY (current_club_id) REFERENCES player_club (id)');
        $this->addSql('CREATE INDEX IDX_98197A65CB148FB7 ON player (current_club_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65CB148FB7');
        $this->addSql('DROP INDEX IDX_98197A65CB148FB7 ON player');
        $this->addSql('ALTER TABLE player ADD current_club VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP current_club_id');
    }
}
