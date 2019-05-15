<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181207154759 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tcompra (id INT AUTO_INCREMENT NOT NULL, proveedor_id INT NOT NULL, numero_factura VARCHAR(15) NOT NULL, fecha_emision DATE NOT NULL, sub_total NUMERIC(10, 2) DEFAULT NULL, iva NUMERIC(10, 2) DEFAULT NULL, total NUMERIC(10, 2) DEFAULT NULL, INDEX IDX_AA48BB1ACB305D73 (proveedor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tcompra ADD CONSTRAINT FK_AA48BB1ACB305D73 FOREIGN KEY (proveedor_id) REFERENCES tproveedor (id_proveedor)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tcompra');
    }
}
