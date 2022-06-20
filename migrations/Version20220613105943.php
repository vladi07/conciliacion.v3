<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220613105943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE persona_id_seq CASCADE');
        $this->addSql('DROP TABLE agenda_caso_conciliatorio');
        $this->addSql('DROP TABLE agenda_sala');
        $this->addSql('DROP TABLE caso_conciliatorio_sala');
        $this->addSql('DROP TABLE caso_conciliatorio_usuario_externo');
        $this->addSql('DROP TABLE usuario_caso_conciliatorio');
        $this->addSql('DROP TABLE agenda_usuario');
        $this->addSql('ALTER TABLE caso_conciliatorio ALTER centro_id SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE persona_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE agenda_caso_conciliatorio (agenda_id INT NOT NULL, caso_conciliatorio_id INT NOT NULL, PRIMARY KEY(agenda_id, caso_conciliatorio_id))');
        $this->addSql('CREATE INDEX idx_df06dbf6531fba0f ON agenda_caso_conciliatorio (caso_conciliatorio_id)');
        $this->addSql('CREATE INDEX idx_df06dbf6ea67784a ON agenda_caso_conciliatorio (agenda_id)');
        $this->addSql('CREATE TABLE agenda_sala (agenda_id INT NOT NULL, sala_id INT NOT NULL, PRIMARY KEY(agenda_id, sala_id))');
        $this->addSql('CREATE INDEX idx_df03a66cea67784a ON agenda_sala (agenda_id)');
        $this->addSql('CREATE INDEX idx_df03a66cc51cdf3f ON agenda_sala (sala_id)');
        $this->addSql('CREATE TABLE caso_conciliatorio_sala (caso_conciliatorio_id INT NOT NULL, sala_id INT NOT NULL, PRIMARY KEY(caso_conciliatorio_id, sala_id))');
        $this->addSql('CREATE INDEX idx_276707c8c51cdf3f ON caso_conciliatorio_sala (sala_id)');
        $this->addSql('CREATE INDEX idx_276707c8531fba0f ON caso_conciliatorio_sala (caso_conciliatorio_id)');
        $this->addSql('CREATE TABLE caso_conciliatorio_usuario_externo (caso_conciliatorio_id INT NOT NULL, usuario_externo_id INT NOT NULL, PRIMARY KEY(caso_conciliatorio_id, usuario_externo_id))');
        $this->addSql('CREATE INDEX idx_407201a736ee94 ON caso_conciliatorio_usuario_externo (usuario_externo_id)');
        $this->addSql('CREATE INDEX idx_407201a531fba0f ON caso_conciliatorio_usuario_externo (caso_conciliatorio_id)');
        $this->addSql('CREATE TABLE usuario_caso_conciliatorio (usuario_id INT NOT NULL, caso_conciliatorio_id INT NOT NULL, PRIMARY KEY(usuario_id, caso_conciliatorio_id))');
        $this->addSql('CREATE INDEX idx_26b0fe0f531fba0f ON usuario_caso_conciliatorio (caso_conciliatorio_id)');
        $this->addSql('CREATE INDEX idx_26b0fe0fdb38439e ON usuario_caso_conciliatorio (usuario_id)');
        $this->addSql('CREATE TABLE agenda_usuario (agenda_id INT NOT NULL, usuario_id INT NOT NULL, PRIMARY KEY(agenda_id, usuario_id))');
        $this->addSql('CREATE INDEX idx_a1a1d21cdb38439e ON agenda_usuario (usuario_id)');
        $this->addSql('CREATE INDEX idx_a1a1d21cea67784a ON agenda_usuario (agenda_id)');
        $this->addSql('ALTER TABLE agenda_caso_conciliatorio ADD CONSTRAINT fk_df06dbf6ea67784a FOREIGN KEY (agenda_id) REFERENCES agenda (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE agenda_caso_conciliatorio ADD CONSTRAINT fk_df06dbf6531fba0f FOREIGN KEY (caso_conciliatorio_id) REFERENCES caso_conciliatorio (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE agenda_sala ADD CONSTRAINT fk_df03a66cea67784a FOREIGN KEY (agenda_id) REFERENCES agenda (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE agenda_sala ADD CONSTRAINT fk_df03a66cc51cdf3f FOREIGN KEY (sala_id) REFERENCES sala (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE caso_conciliatorio_sala ADD CONSTRAINT fk_276707c8531fba0f FOREIGN KEY (caso_conciliatorio_id) REFERENCES caso_conciliatorio (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE caso_conciliatorio_sala ADD CONSTRAINT fk_276707c8c51cdf3f FOREIGN KEY (sala_id) REFERENCES sala (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE caso_conciliatorio_usuario_externo ADD CONSTRAINT fk_407201a531fba0f FOREIGN KEY (caso_conciliatorio_id) REFERENCES caso_conciliatorio (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE caso_conciliatorio_usuario_externo ADD CONSTRAINT fk_407201a736ee94 FOREIGN KEY (usuario_externo_id) REFERENCES usuario_externo (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE usuario_caso_conciliatorio ADD CONSTRAINT fk_26b0fe0fdb38439e FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE usuario_caso_conciliatorio ADD CONSTRAINT fk_26b0fe0f531fba0f FOREIGN KEY (caso_conciliatorio_id) REFERENCES caso_conciliatorio (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE agenda_usuario ADD CONSTRAINT fk_a1a1d21cea67784a FOREIGN KEY (agenda_id) REFERENCES agenda (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE agenda_usuario ADD CONSTRAINT fk_a1a1d21cdb38439e FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE caso_conciliatorio ALTER centro_id DROP NOT NULL');
    }
}
