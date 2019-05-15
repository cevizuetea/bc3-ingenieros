<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190123235050 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tgaleria_proyecto ADD deescripcion VARCHAR(500) DEFAULT NULL, CHANGE nombre_imagen nombre_imagen VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tproyecto DROP INDEX UNIQ_41B65BA7EC3656E, ADD INDEX IDX_41B65BA7EC3656E (trabajador_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE tgaleria_proyecto DROP deescripcion, CHANGE nombre_imagen nombre_imagen VARCHAR(500) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE tproyecto DROP INDEX IDX_41B65BA7EC3656E, ADD UNIQUE INDEX UNIQ_41B65BA7EC3656E (trabajador_id)');
    }
}
