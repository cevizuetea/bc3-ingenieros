<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190130225312 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tseguimiento_proyecto_herramientas ADD fecha DATE NOT NULL');
        $this->addSql('ALTER TABLE tseguimiento_proyecto_materiales ADD fecha DATE NOT NULL');
        $this->addSql('ALTER TABLE tseguimiento_proyecto_trabajadores ADD fecha DATE NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tseguimiento_proyecto_herramientas DROP fecha');
        $this->addSql('ALTER TABLE tseguimiento_proyecto_materiales DROP fecha');
        $this->addSql('ALTER TABLE tseguimiento_proyecto_trabajadores DROP fecha');
    }
}
