<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181026225503 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tdetalle_proyecto_herramientas (id INT AUTO_INCREMENT NOT NULL, proyecto_id INT NOT NULL, herramienta_id INT NOT NULL, INDEX IDX_8F2BD856F625D1BA (proyecto_id), UNIQUE INDEX UNIQ_8F2BD856B2C900C2 (herramienta_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tdetalle_proyecto_herramientas ADD CONSTRAINT FK_8F2BD856F625D1BA FOREIGN KEY (proyecto_id) REFERENCES tproyecto (id_proyecto)');
        $this->addSql('ALTER TABLE tdetalle_proyecto_herramientas ADD CONSTRAINT FK_8F2BD856B2C900C2 FOREIGN KEY (herramienta_id) REFERENCES therramienta (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tdetalle_proyecto_herramientas');
    }
}
