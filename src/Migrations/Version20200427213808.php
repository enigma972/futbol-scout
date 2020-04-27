<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200427213808 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player ADD referent_id INT NOT NULL');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A6535E47E35 FOREIGN KEY (referent_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_98197A6535E47E35 ON player (referent_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A6535E47E35');
        $this->addSql('DROP INDEX IDX_98197A6535E47E35 ON player');
        $this->addSql('ALTER TABLE player DROP referent_id');
    }
}
