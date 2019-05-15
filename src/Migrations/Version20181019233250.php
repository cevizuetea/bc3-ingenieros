<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181019233250 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE therramienta (id INT AUTO_INCREMENT NOT NULL, marca_id INT NOT NULL, estado_id INT NOT NULL, codigo VARCHAR(15) NOT NULL, nombre_herramienta VARCHAR(50) NOT NULL, descripcion_herramienta VARCHAR(250) NOT NULL, ocupado INT NOT NULL, INDEX IDX_83BEFBDD81EF0041 (marca_id), INDEX IDX_83BEFBDD9F5A440B (estado_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE therramienta ADD CONSTRAINT FK_83BEFBDD81EF0041 FOREIGN KEY (marca_id) REFERENCES tmarcab (id)');
        $this->addSql('ALTER TABLE therramienta ADD CONSTRAINT FK_83BEFBDD9F5A440B FOREIGN KEY (estado_id) REFERENCES testado_bodega (id_estado)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE therramienta');
    }
}
