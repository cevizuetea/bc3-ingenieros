<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181001214801 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE t_archivos_proyecto DROP FOREIGN KEY t_archivos_proyecto_ibfk_1');
        $this->addSql('ALTER TABLE t_detalle_compra DROP FOREIGN KEY t_detalle_compra_ibfk_2');
        $this->addSql('ALTER TABLE t_detalle_proyecto DROP FOREIGN KEY t_detalle_proyecto_ibfk_2');
        $this->addSql('ALTER TABLE t_detalle_solicitud DROP FOREIGN KEY t_detalle_solicitud_ibfk_2');
        $this->addSql('ALTER TABLE t_empleado DROP FOREIGN KEY t_empleado_ibfk_1');
        $this->addSql('ALTER TABLE t_proyecto DROP FOREIGN KEY t_proyecto_ibfk_1');
        $this->addSql('ALTER TABLE t_detalle_compra DROP FOREIGN KEY t_detalle_compra_ibfk_1');
        $this->addSql('ALTER TABLE t_detalle_solicitud DROP FOREIGN KEY t_detalle_solicitud_ibfk_1');
        $this->addSql('ALTER TABLE t_proyecto DROP FOREIGN KEY t_proyecto_ibfk_3');
        $this->addSql('ALTER TABLE t_bodega DROP FOREIGN KEY t_bodega_ibfk_3');
        $this->addSql('ALTER TABLE t_proyecto DROP FOREIGN KEY t_proyecto_ibfk_2');
        $this->addSql('ALTER TABLE t_bodega DROP FOREIGN KEY t_bodega_ibfk_1');
        $this->addSql('ALTER TABLE t_compra DROP FOREIGN KEY t_compra_ibfk_1');
        $this->addSql('ALTER TABLE t_avance_proyecto DROP FOREIGN KEY t_avance_proyecto_ibfk_1');
        $this->addSql('ALTER TABLE t_detalle_proyecto DROP FOREIGN KEY t_detalle_proyecto_ibfk_1');
        $this->addSql('ALTER TABLE t_bodega DROP FOREIGN KEY t_bodega_ibfk_2');
        $this->addSql('CREATE TABLE tmarcab (id INT AUTO_INCREMENT NOT NULL, nombre_marca VARCHAR(20) NOT NULL, descripcion VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8_spanish_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE t_archivos_proyecto');
        $this->addSql('DROP TABLE t_avance_proyecto');
        $this->addSql('DROP TABLE t_bodega');
        $this->addSql('DROP TABLE t_cargo');
        $this->addSql('DROP TABLE t_cliente');
        $this->addSql('DROP TABLE t_compra');
        $this->addSql('DROP TABLE t_detalle_compra');
        $this->addSql('DROP TABLE t_detalle_proyecto');
        $this->addSql('DROP TABLE t_detalle_solicitud');
        $this->addSql('DROP TABLE t_empleado');
        $this->addSql('DROP TABLE t_estado_bodega');
        $this->addSql('DROP TABLE t_estado_proyecto');
        $this->addSql('DROP TABLE t_marcab');
        $this->addSql('DROP TABLE t_proveedor');
        $this->addSql('DROP TABLE t_proyecto');
        $this->addSql('DROP TABLE t_tipob');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE t_archivos_proyecto (id_archivo INT NOT NULL, nombre_archivo VARCHAR(50) NOT NULL COLLATE utf8_spanish_ci, descripion VARCHAR(50) NOT NULL COLLATE utf8_spanish_ci, id_avance INT NOT NULL, INDEX id_avance (id_avance), PRIMARY KEY(id_archivo)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE t_avance_proyecto (id_avance_proyecto INT NOT NULL, id_proyecto INT NOT NULL, fecha_avance DATE NOT NULL, descripcion VARCHAR(50) NOT NULL COLLATE utf8_spanish_ci, INDEX id_proyecto (id_proyecto), PRIMARY KEY(id_avance_proyecto)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE t_bodega (id_bodega VARCHAR(10) NOT NULL COLLATE utf8_spanish_ci, id_tipob INT NOT NULL, id_marcab INT NOT NULL, id_estado INT NOT NULL, nombre VARCHAR(20) NOT NULL COLLATE utf8_spanish_ci, descripcion VARCHAR(20) NOT NULL COLLATE utf8_spanish_ci, cantidad INT NOT NULL, precio_unitario DOUBLE PRECISION NOT NULL, precio_total DOUBLE PRECISION NOT NULL, INDEX id_tipob (id_tipob), INDEX id_marcab (id_marcab), INDEX id_estado (id_estado), PRIMARY KEY(id_bodega)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE t_cargo (id_cargo INT NOT NULL, nombre_cargo VARCHAR(20) NOT NULL COLLATE utf8_spanish_ci, descripcion VARCHAR(20) NOT NULL COLLATE utf8_spanish_ci, PRIMARY KEY(id_cargo)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE t_cliente (id_cliente INT NOT NULL, nombre INT NOT NULL, direccion INT NOT NULL, telefono INT NOT NULL, PRIMARY KEY(id_cliente)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE t_compra (id_factura INT NOT NULL, id_proveedor INT NOT NULL, fecha DATE NOT NULL, subtotal_compra DOUBLE PRECISION NOT NULL, iva_compra DOUBLE PRECISION NOT NULL, total_compra DOUBLE PRECISION NOT NULL, INDEX id_proveedor (id_proveedor), PRIMARY KEY(id_factura)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE t_detalle_compra (id_compra INT NOT NULL, id_bodega VARCHAR(10) NOT NULL COLLATE utf8_spanish_ci, cantidad INT NOT NULL, precio_unitario DOUBLE PRECISION NOT NULL, precio_total DOUBLE PRECISION NOT NULL, INDEX id_compra (id_compra), INDEX id_bodega (id_bodega)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE t_detalle_proyecto (id_bodega VARCHAR(10) NOT NULL COLLATE utf8_spanish_ci, id_proyecto INT NOT NULL, cantidad INT NOT NULL, precio_unitario DOUBLE PRECISION NOT NULL, precio_total DOUBLE PRECISION NOT NULL, INDEX id_bodega (id_bodega), INDEX id_proyecto (id_proyecto)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE t_detalle_solicitud (id_solicitud INT NOT NULL, id_empleado VARCHAR(10) NOT NULL COLLATE utf8_spanish_ci, id_bodega VARCHAR(10) NOT NULL COLLATE utf8_spanish_ci, cantidad INT NOT NULL, INDEX id_empleado (id_empleado), INDEX id_bodega (id_bodega), PRIMARY KEY(id_solicitud)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE t_empleado (id_empleado VARCHAR(6) NOT NULL COLLATE utf8_spanish_ci, id_cargo INT NOT NULL, ci VARCHAR(10) NOT NULL COLLATE utf8_spanish_ci, nombres VARCHAR(20) NOT NULL COLLATE utf8_spanish_ci, apellidos VARCHAR(20) NOT NULL COLLATE utf8_spanish_ci, edad INT NOT NULL, direccion VARCHAR(20) NOT NULL COLLATE utf8_spanish_ci, telefono VARCHAR(10) NOT NULL COLLATE utf8_spanish_ci, fecha_ingreso DATE NOT NULL, sueldo DOUBLE PRECISION NOT NULL, fecha_salda DATE NOT NULL, contraseña VARCHAR(20) NOT NULL COLLATE utf8_spanish_ci, INDEX id_cargo (id_cargo), INDEX id_cargo_2 (id_cargo), PRIMARY KEY(id_empleado)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE t_estado_bodega (id_estado INT NOT NULL, nombre_estado VARCHAR(15) NOT NULL COLLATE utf8_spanish_ci, descripcion VARCHAR(20) NOT NULL COLLATE utf8_spanish_ci, PRIMARY KEY(id_estado)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE t_estado_proyecto (id_estado_proyecto INT NOT NULL, nombre_estado VARCHAR(30) NOT NULL COLLATE utf8_spanish_ci, descripcion VARCHAR(50) NOT NULL COLLATE utf8_spanish_ci, PRIMARY KEY(id_estado_proyecto)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE t_marcab (id INT NOT NULL, nombre_marca VARCHAR(20) NOT NULL COLLATE utf8_spanish_ci, descripcion VARCHAR(255) NOT NULL COLLATE utf8_spanish_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE t_proveedor (id_proveedor INT NOT NULL, nombre_prov VARCHAR(20) NOT NULL COLLATE utf8_spanish_ci, ruc VARCHAR(20) NOT NULL COLLATE utf8_spanish_ci, direccion VARCHAR(20) NOT NULL COLLATE utf8_spanish_ci, telefono VARCHAR(10) NOT NULL COLLATE utf8_spanish_ci, PRIMARY KEY(id_proveedor)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE t_proyecto (id_proyecto INT NOT NULL, id_cliente INT NOT NULL, id_empleado VARCHAR(20) NOT NULL COLLATE utf8_spanish_ci, id_estado_proyecto INT NOT NULL, nombre_proyecto INT NOT NULL, direccion_proyecto INT NOT NULL, cotizacion VARCHAR(50) NOT NULL COLLATE utf8_spanish_ci, fecha_inicio DOUBLE PRECISION NOT NULL, fecha_fin INT DEFAULT NULL, INDEX id_cliente (id_cliente), INDEX id_empleado (id_empleado), INDEX id_estado_proyecto (id_estado_proyecto), PRIMARY KEY(id_proyecto)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE t_tipob (id_tipo INT NOT NULL, nombre_tipo VARCHAR(10) NOT NULL COLLATE utf8_spanish_ci, descripcion VARCHAR(20) NOT NULL COLLATE utf8_spanish_ci, PRIMARY KEY(id_tipo)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE t_archivos_proyecto ADD CONSTRAINT t_archivos_proyecto_ibfk_1 FOREIGN KEY (id_archivo) REFERENCES t_avance_proyecto (id_avance_proyecto)');
        $this->addSql('ALTER TABLE t_avance_proyecto ADD CONSTRAINT t_avance_proyecto_ibfk_1 FOREIGN KEY (id_proyecto) REFERENCES t_proyecto (id_proyecto)');
        $this->addSql('ALTER TABLE t_bodega ADD CONSTRAINT t_bodega_ibfk_1 FOREIGN KEY (id_marcab) REFERENCES t_marcab (id)');
        $this->addSql('ALTER TABLE t_bodega ADD CONSTRAINT t_bodega_ibfk_2 FOREIGN KEY (id_tipob) REFERENCES t_tipob (id_tipo)');
        $this->addSql('ALTER TABLE t_bodega ADD CONSTRAINT t_bodega_ibfk_3 FOREIGN KEY (id_estado) REFERENCES t_estado_bodega (id_estado)');
        $this->addSql('ALTER TABLE t_compra ADD CONSTRAINT t_compra_ibfk_1 FOREIGN KEY (id_proveedor) REFERENCES t_proveedor (id_proveedor)');
        $this->addSql('ALTER TABLE t_detalle_compra ADD CONSTRAINT t_detalle_compra_ibfk_1 FOREIGN KEY (id_compra) REFERENCES t_compra (id_factura)');
        $this->addSql('ALTER TABLE t_detalle_compra ADD CONSTRAINT t_detalle_compra_ibfk_2 FOREIGN KEY (id_bodega) REFERENCES t_bodega (id_bodega)');
        $this->addSql('ALTER TABLE t_detalle_proyecto ADD CONSTRAINT t_detalle_proyecto_ibfk_1 FOREIGN KEY (id_proyecto) REFERENCES t_proyecto (id_proyecto)');
        $this->addSql('ALTER TABLE t_detalle_proyecto ADD CONSTRAINT t_detalle_proyecto_ibfk_2 FOREIGN KEY (id_bodega) REFERENCES t_bodega (id_bodega)');
        $this->addSql('ALTER TABLE t_detalle_solicitud ADD CONSTRAINT t_detalle_solicitud_ibfk_1 FOREIGN KEY (id_empleado) REFERENCES t_empleado (id_empleado)');
        $this->addSql('ALTER TABLE t_detalle_solicitud ADD CONSTRAINT t_detalle_solicitud_ibfk_2 FOREIGN KEY (id_bodega) REFERENCES t_bodega (id_bodega)');
        $this->addSql('ALTER TABLE t_empleado ADD CONSTRAINT t_empleado_ibfk_1 FOREIGN KEY (id_cargo) REFERENCES t_cargo (id_cargo)');
        $this->addSql('ALTER TABLE t_proyecto ADD CONSTRAINT t_proyecto_ibfk_1 FOREIGN KEY (id_cliente) REFERENCES t_cliente (id_cliente)');
        $this->addSql('ALTER TABLE t_proyecto ADD CONSTRAINT t_proyecto_ibfk_2 FOREIGN KEY (id_estado_proyecto) REFERENCES t_estado_proyecto (id_estado_proyecto)');
        $this->addSql('ALTER TABLE t_proyecto ADD CONSTRAINT t_proyecto_ibfk_3 FOREIGN KEY (id_empleado) REFERENCES t_empleado (id_empleado)');
        $this->addSql('DROP TABLE tmarcab');
    }
}
