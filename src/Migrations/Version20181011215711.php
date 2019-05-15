<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181011215711 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tproveedor (id_proveedor INT AUTO_INCREMENT NOT NULL, nombre_proveedor VARCHAR(200) NOT NULL, ruc VARCHAR(15) NOT NULL, direccion VARCHAR(200) NOT NULL, telefono VARCHAR(15) NOT NULL, PRIMARY KEY(id_proveedor)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE tproveeror');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tproveeror (id_proveedor INT AUTO_INCREMENT NOT NULL, nombre_proveedor VARCHAR(200) NOT NULL COLLATE utf8mb4_unicode_ci, ruc VARCHAR(15) NOT NULL COLLATE utf8mb4_unicode_ci, direccion VARCHAR(200) NOT NULL COLLATE utf8mb4_unicode_ci, telefono VARCHAR(15) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id_proveedor)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE tproveedor');
    }
}
