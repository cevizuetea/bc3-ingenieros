<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190201160444 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tcargo ADD eliminado INT NOT NULL');
        $this->addSql('ALTER TABLE testado_bodega ADD eliminado INT NOT NULL');
        $this->addSql('ALTER TABLE testado_proyecto ADD eliminado INT NOT NULL');
        $this->addSql('ALTER TABLE therramienta ADD eliminado INT NOT NULL');
        $this->addSql('ALTER TABLE tmarcab ADD eliminado INT NOT NULL');
        $this->addSql('ALTER TABLE tmaterial ADD eliminado INT NOT NULL');
        $this->addSql('ALTER TABLE tproveedor ADD eliminado INT NOT NULL');
        $this->addSql('ALTER TABLE tproyecto ADD eliminado INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tcargo DROP eliminado');
        $this->addSql('ALTER TABLE testado_bodega DROP eliminado');
        $this->addSql('ALTER TABLE testado_proyecto DROP eliminado');
        $this->addSql('ALTER TABLE therramienta DROP eliminado');
        $this->addSql('ALTER TABLE tmarcab DROP eliminado');
        $this->addSql('ALTER TABLE tmaterial DROP eliminado');
        $this->addSql('ALTER TABLE tproveedor DROP eliminado');
        $this->addSql('ALTER TABLE tproyecto DROP eliminado');
    }
}
