<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190109232247 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE tgaleria_proyecto (id INT AUTO_INCREMENT NOT NULL, avance_id INT NOT NULL, nombre_imagen VARCHAR(500) NOT NULL, INDEX IDX_2E0C0F5E937B26AB (avance_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tgaleria_proyecto ADD CONSTRAINT FK_2E0C0F5E937B26AB FOREIGN KEY (avance_id) REFERENCES tavance_proyecto (id)');
        $this->addSql('ALTER TABLE tavance_proyecto ADD observaciones VARCHAR(500) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE tgaleria_proyecto');
        $this->addSql('ALTER TABLE tavance_proyecto DROP observaciones');
    }
}
