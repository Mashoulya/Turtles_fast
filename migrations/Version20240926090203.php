<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240926090203 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users ADD turtles_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E99E208D97 FOREIGN KEY (turtles_id) REFERENCES turtles (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E99E208D97 ON users (turtles_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E99E208D97');
        $this->addSql('DROP INDEX IDX_1483A5E99E208D97 ON users');
        $this->addSql('ALTER TABLE users DROP turtles_id');
    }
}
