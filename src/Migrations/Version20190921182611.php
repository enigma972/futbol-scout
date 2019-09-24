<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190921182611 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player ADD promo_clip_id INT DEFAULT NULL, DROP promo_clip');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65366D5797 FOREIGN KEY (promo_clip_id) REFERENCES player_promo_clip (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98197A65366D5797 ON player (promo_clip_id)');
        $this->addSql('ALTER TABLE player_promo_clip CHANGE size size INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65366D5797');
        $this->addSql('DROP INDEX UNIQ_98197A65366D5797 ON player');
        $this->addSql('ALTER TABLE player ADD promo_clip VARCHAR(100) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP promo_clip_id');
        $this->addSql('ALTER TABLE player_promo_clip CHANGE size size VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
