<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181211004141 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tdetalle_compra (id INT AUTO_INCREMENT NOT NULL, compra_id INT NOT NULL, codigo VARCHAR(25) NOT NULL, cantidad INT NOT NULL, detalle VARCHAR(25) NOT NULL, precio_unitario NUMERIC(10, 0) NOT NULL, precio_total NUMERIC(10, 0) NOT NULL, tipo VARCHAR(25) NOT NULL, INDEX IDX_785117B7F2E704D7 (compra_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tdetalle_compra ADD CONSTRAINT FK_785117B7F2E704D7 FOREIGN KEY (compra_id) REFERENCES tcompra (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tdetalle_compra');
    }
}
