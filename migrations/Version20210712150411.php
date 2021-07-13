<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210712150411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles CHANGE author_id author_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE authors ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8E0C2A51989D9B62 ON authors (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE articles CHANGE author_id author_id INT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_8E0C2A51989D9B62 ON authors');
        $this->addSql('ALTER TABLE authors DROP slug');
    }
}
