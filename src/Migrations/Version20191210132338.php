<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191210132338 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE errand_item (id INT AUTO_INCREMENT NOT NULL, errand_id INT NOT NULL, name VARCHAR(255) NOT NULL, bought TINYINT(1) NOT NULL, INDEX IDX_B65C4DA9AD91EE0F (errand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE errand_item ADD CONSTRAINT FK_B65C4DA9AD91EE0F FOREIGN KEY (errand_id) REFERENCES errand (id)');
        $this->addSql('ALTER TABLE spending CHANGE date date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE validate validate VARCHAR(255) DEFAULT NULL, CHANGE avatar avatar VARCHAR(255) DEFAULT NULL, CHANGE nickname nickname VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE errand_item');
        $this->addSql('ALTER TABLE spending CHANGE date date DATE DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE user CHANGE validate validate VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE avatar avatar VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE nickname nickname VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
    }
}
