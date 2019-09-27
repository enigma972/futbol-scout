<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190927041402 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_player (user_id INT NOT NULL, player_id INT NOT NULL, INDEX IDX_FD4B6158A76ED395 (user_id), INDEX IDX_FD4B615899E6F5DF (player_id), PRIMARY KEY(user_id, player_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_player ADD CONSTRAINT FK_FD4B6158A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_player ADD CONSTRAINT FK_FD4B615899E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494637AB2F');
        $this->addSql('DROP INDEX IDX_8D93D6494637AB2F ON user');
        $this->addSql('ALTER TABLE user DROP favorites_player_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_player');
        $this->addSql('ALTER TABLE user ADD favorites_player_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494637AB2F FOREIGN KEY (favorites_player_id) REFERENCES player (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6494637AB2F ON user (favorites_player_id)');
    }
}
