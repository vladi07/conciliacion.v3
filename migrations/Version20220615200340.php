<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220615200340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE caso_conciliatorio DROP CONSTRAINT fk_254d19e9a520eb5f');
        $this->addSql('DROP INDEX idx_254d19e9a520eb5f');
        $this->addSql('ALTER TABLE caso_conciliatorio DROP conciliador_id');
        $this->addSql('ALTER TABLE caso_conciliatorio ALTER centro_id DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE caso_conciliatorio ADD conciliador_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE caso_conciliatorio ALTER centro_id SET NOT NULL');
        $this->addSql('ALTER TABLE caso_conciliatorio ADD CONSTRAINT fk_254d19e9a520eb5f FOREIGN KEY (conciliador_id) REFERENCES usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_254d19e9a520eb5f ON caso_conciliatorio (conciliador_id)');
    }
}
