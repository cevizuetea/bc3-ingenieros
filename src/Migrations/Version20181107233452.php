<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181107233452 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tmaterial (id INT AUTO_INCREMENT NOT NULL, marcaid INT NOT NULL, codigo_material VARCHAR(15) NOT NULL, nombre_material VARCHAR(50) NOT NULL, descripcion_material VARCHAR(250) NOT NULL, cantidad INT NOT NULL, precio_unitario NUMERIC(10, 2) NOT NULL, precio_total NUMERIC(10, 2) NOT NULL, INDEX IDX_52DA2C8BA9D1115E (marcaid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tmaterial ADD CONSTRAINT FK_52DA2C8BA9D1115E FOREIGN KEY (marcaid) REFERENCES tmarcab (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tmaterial');
    }
}
