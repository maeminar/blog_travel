<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240619211657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE transport (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD transport_id INT DEFAULT NULL, DROP transport');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E669909C13F FOREIGN KEY (transport_id) REFERENCES transport (id)');
        $this->addSql('CREATE INDEX IDX_23A0E669909C13F ON article (transport_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E669909C13F');
        $this->addSql('DROP TABLE transport');
        $this->addSql('DROP INDEX IDX_23A0E669909C13F ON article');
        $this->addSql('ALTER TABLE article ADD transport VARCHAR(255) NOT NULL, DROP transport_id');
    }
}
