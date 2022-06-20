<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220613124651 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE caso_conciliatorio ADD conciliador_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE caso_conciliatorio ADD CONSTRAINT FK_254D19E9A520EB5F FOREIGN KEY (conciliador_id) REFERENCES usuario (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_254D19E9A520EB5F ON caso_conciliatorio (conciliador_id)');
        $this->addSql('ALTER TABLE usuario DROP CONSTRAINT fk_2265b05d531fba0f');
        $this->addSql('DROP INDEX idx_2265b05d531fba0f');
        $this->addSql('ALTER TABLE usuario DROP caso_conciliatorio_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE usuario ADD caso_conciliatorio_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE usuario ADD CONSTRAINT fk_2265b05d531fba0f FOREIGN KEY (caso_conciliatorio_id) REFERENCES caso_conciliatorio (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_2265b05d531fba0f ON usuario (caso_conciliatorio_id)');
        $this->addSql('ALTER TABLE caso_conciliatorio DROP CONSTRAINT FK_254D19E9A520EB5F');
        $this->addSql('DROP INDEX IDX_254D19E9A520EB5F');
        $this->addSql('ALTER TABLE caso_conciliatorio DROP conciliador_id');
    }
}
