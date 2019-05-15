<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181204225616 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tdetalle_proyecto_trabajadores (id INT AUTO_INCREMENT NOT NULL, idproyecto INT NOT NULL, trabajador_id INT NOT NULL, INDEX IDX_AD649A79C5074AB4 (idproyecto), INDEX IDX_AD649A79EC3656E (trabajador_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tdetalle_proyecto_trabajadores ADD CONSTRAINT FK_AD649A79C5074AB4 FOREIGN KEY (idproyecto) REFERENCES tproyecto (id_proyecto)');
        $this->addSql('ALTER TABLE tdetalle_proyecto_trabajadores ADD CONSTRAINT FK_AD649A79EC3656E FOREIGN KEY (trabajador_id) REFERENCES ttrabajadores (id_trabajador)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tdetalle_proyecto_trabajadores');
    }
}
