<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200105015645 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, avatar_id INT DEFAULT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, mail VARCHAR(100) NOT NULL, phone VARCHAR(20) DEFAULT NULL, created_at DATETIME NOT NULL, birthday DATETIME NOT NULL, gender VARCHAR(10) NOT NULL, country VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, is_complete TINYINT(1) NOT NULL, nb_followers INT NOT NULL, nb_follows INT NOT NULL, UNIQUE INDEX UNIQ_8D93D6495126AC48 (mail), UNIQUE INDEX UNIQ_8D93D649444F97DD (phone), UNIQUE INDEX UNIQ_8D93D64986383B10 (avatar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_user (user_source INT NOT NULL, user_target INT NOT NULL, INDEX IDX_F7129A803AD8644E (user_source), INDEX IDX_F7129A80233D34C1 (user_target), PRIMARY KEY(user_source, user_target)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_player (user_id INT NOT NULL, player_id INT NOT NULL, INDEX IDX_FD4B6158A76ED395 (user_id), INDEX IDX_FD4B615899E6F5DF (player_id), PRIMARY KEY(user_id, player_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avatar (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) DEFAULT NULL, alt VARCHAR(100) DEFAULT NULL, path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_like (author_id INT NOT NULL, post_id INT NOT NULL, time DATETIME NOT NULL, INDEX IDX_653627B8F675F31B (author_id), INDEX IDX_653627B84B89032C (post_id), PRIMARY KEY(author_id, post_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, current_club_id INT NOT NULL, promo_clip_id INT DEFAULT NULL, picture_id INT NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, nickname VARCHAR(100) NOT NULL, birthday DATETIME DEFAULT NULL, gender VARCHAR(10) NOT NULL, country VARCHAR(255) NOT NULL, length INT DEFAULT NULL, weight INT DEFAULT NULL, strong_feets LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', postes LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', status VARCHAR(100) DEFAULT NULL, ambition LONGTEXT DEFAULT NULL, biographie LONGTEXT DEFAULT NULL, level VARCHAR(100) DEFAULT NULL, nb_fans INT NOT NULL, nb_notices INT NOT NULL, pseudo VARCHAR(255) DEFAULT NULL, INDEX IDX_98197A65CB148FB7 (current_club_id), UNIQUE INDEX UNIQ_98197A65366D5797 (promo_clip_id), UNIQUE INDEX UNIQ_98197A65EE45BDBF (picture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_club (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(150) NOT NULL, abbr_label VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_notice (author_id INT NOT NULL, player_id INT NOT NULL, time DATETIME NOT NULL, content VARCHAR(255) NOT NULL, is_locked TINYINT(1) NOT NULL, INDEX IDX_D70DD31CF675F31B (author_id), INDEX IDX_D70DD31C99E6F5DF (player_id), PRIMARY KEY(author_id, player_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_page (id INT AUTO_INCREMENT NOT NULL, player_id INT NOT NULL, UNIQUE INDEX UNIQ_B610E61399E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_page_manager (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, page_id INT NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_80799E0EA76ED395 (user_id), INDEX IDX_80799E0EC4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_picture (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) DEFAULT NULL, alt VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_promo_clip (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) DEFAULT NULL, alt VARCHAR(100) DEFAULT NULL, path VARCHAR(255) DEFAULT NULL, size INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, attachement_id INT DEFAULT NULL, content LONGTEXT DEFAULT NULL, posted_at DATETIME NOT NULL, nb_comments INT NOT NULL, nb_likes INT NOT NULL, INDEX IDX_5A8A6C8DF675F31B (author_id), UNIQUE INDEX UNIQ_5A8A6C8DA05591E0 (attachement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_attachement (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) DEFAULT NULL, alt VARCHAR(100) DEFAULT NULL, path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_comment (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, post_id INT NOT NULL, time DATETIME NOT NULL, content VARCHAR(255) NOT NULL, INDEX IDX_A99CE55FF675F31B (author_id), INDEX IDX_A99CE55F4B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, token VARCHAR(100) NOT NULL, expire_at DATETIME NOT NULL, is_used TINYINT(1) NOT NULL, INDEX IDX_B9983CE5A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64986383B10 FOREIGN KEY (avatar_id) REFERENCES avatar (id)');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A803AD8644E FOREIGN KEY (user_source) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_user ADD CONSTRAINT FK_F7129A80233D34C1 FOREIGN KEY (user_target) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_player ADD CONSTRAINT FK_FD4B6158A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_player ADD CONSTRAINT FK_FD4B615899E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B8F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post_like ADD CONSTRAINT FK_653627B84B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65CB148FB7 FOREIGN KEY (current_club_id) REFERENCES player_club (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65366D5797 FOREIGN KEY (promo_clip_id) REFERENCES player_promo_clip (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65EE45BDBF FOREIGN KEY (picture_id) REFERENCES player_picture (id)');
        $this->addSql('ALTER TABLE player_notice ADD CONSTRAINT FK_D70DD31CF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE player_notice ADD CONSTRAINT FK_D70DD31C99E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE player_page ADD CONSTRAINT FK_B610E61399E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE player_page_manager ADD CONSTRAINT FK_80799E0EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE player_page_manager ADD CONSTRAINT FK_80799E0EC4663E4 FOREIGN KEY (page_id) REFERENCES player_page (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA05591E0 FOREIGN KEY (attachement_id) REFERENCES post_attachement (id)');
        $this->addSql('ALTER TABLE post_comment ADD CONSTRAINT FK_A99CE55FF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post_comment ADD CONSTRAINT FK_A99CE55F4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE reset_password ADD CONSTRAINT FK_B9983CE5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user_user DROP FOREIGN KEY FK_F7129A803AD8644E');
        $this->addSql('ALTER TABLE user_user DROP FOREIGN KEY FK_F7129A80233D34C1');
        $this->addSql('ALTER TABLE user_player DROP FOREIGN KEY FK_FD4B6158A76ED395');
        $this->addSql('ALTER TABLE post_like DROP FOREIGN KEY FK_653627B8F675F31B');
        $this->addSql('ALTER TABLE player_notice DROP FOREIGN KEY FK_D70DD31CF675F31B');
        $this->addSql('ALTER TABLE player_page_manager DROP FOREIGN KEY FK_80799E0EA76ED395');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DF675F31B');
        $this->addSql('ALTER TABLE post_comment DROP FOREIGN KEY FK_A99CE55FF675F31B');
        $this->addSql('ALTER TABLE reset_password DROP FOREIGN KEY FK_B9983CE5A76ED395');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64986383B10');
        $this->addSql('ALTER TABLE user_player DROP FOREIGN KEY FK_FD4B615899E6F5DF');
        $this->addSql('ALTER TABLE player_notice DROP FOREIGN KEY FK_D70DD31C99E6F5DF');
        $this->addSql('ALTER TABLE player_page DROP FOREIGN KEY FK_B610E61399E6F5DF');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65CB148FB7');
        $this->addSql('ALTER TABLE player_page_manager DROP FOREIGN KEY FK_80799E0EC4663E4');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65EE45BDBF');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65366D5797');
        $this->addSql('ALTER TABLE post_like DROP FOREIGN KEY FK_653627B84B89032C');
        $this->addSql('ALTER TABLE post_comment DROP FOREIGN KEY FK_A99CE55F4B89032C');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA05591E0');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_user');
        $this->addSql('DROP TABLE user_player');
        $this->addSql('DROP TABLE avatar');
        $this->addSql('DROP TABLE post_like');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE player_club');
        $this->addSql('DROP TABLE player_notice');
        $this->addSql('DROP TABLE player_page');
        $this->addSql('DROP TABLE player_page_manager');
        $this->addSql('DROP TABLE player_picture');
        $this->addSql('DROP TABLE player_promo_clip');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_attachement');
        $this->addSql('DROP TABLE post_comment');
        $this->addSql('DROP TABLE reset_password');
    }
}
