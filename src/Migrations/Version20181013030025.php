<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181013030025 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ttrabajadores (id_trabajador INT AUTO_INCREMENT NOT NULL, cargo_id INT NOT NULL, ci VARCHAR(10) NOT NULL, nombres VARCHAR(100) NOT NULL, apellidos VARCHAR(100) NOT NULL, edad INT NOT NULL, direccion VARCHAR(200) NOT NULL, telefono VARCHAR(20) NOT NULL, fecha_ingreso DATETIME NOT NULL, sueldo NUMERIC(10, 2) NOT NULL, fecha_salida DATETIME NOT NULL, INDEX IDX_C1A09DB6813AC380 (cargo_id), PRIMARY KEY(id_trabajador)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ttrabajadores ADD CONSTRAINT FK_C1A09DB6813AC380 FOREIGN KEY (cargo_id) REFERENCES tcargo (id_cargo)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE ttrabajadores');
    }
}
