<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181108215435 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tdetalle_proyecto_materiales (id INT AUTO_INCREMENT NOT NULL, proyectoid INT NOT NULL, material_id INT NOT NULL, cantidad_uso INT NOT NULL, INDEX IDX_3F2D219E64307C5F (proyectoid), INDEX IDX_3F2D219EE308AC6F (material_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tdetalle_proyecto_materiales ADD CONSTRAINT FK_3F2D219E64307C5F FOREIGN KEY (proyectoid) REFERENCES tproyecto (id_proyecto)');
        $this->addSql('ALTER TABLE tdetalle_proyecto_materiales ADD CONSTRAINT FK_3F2D219EE308AC6F FOREIGN KEY (material_id) REFERENCES tmaterial (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tdetalle_proyecto_materiales');
    }
}
