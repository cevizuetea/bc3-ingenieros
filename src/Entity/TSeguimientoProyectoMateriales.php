<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TSeguimientoProyectoMaterialesRepository")
 */
class TSeguimientoProyectoMateriales
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $proyectoid;


    /**
     * @ORM\Column(type="integer")
     */
    private $material_id;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $codigomaterial; 

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $material_nombre;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantidad_usar;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    private $precio_total = null;

    /**
     * @ORM\Column(type="integer")
     */
    private $eliminado;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProyectoid()
    {
        return $this->proyectoid;
    }

    public function setProyectoid($proyectoid)
    {
        $this->proyectoid = $proyectoid;

        return $this;
    }

     public function getMaterialId()
    {
        return $this->material_id;
    }

     public function setMaterialId($material_id)
    {
         $this->material_id = $material_id;
        return $this;
    }

    public function getCodigomaterial()
    {
        return $this->codigomaterial;
    }

     public function setCodigomaterial($codigomaterial)
    {
         $this->codigomaterial = $codigomaterial;
        return $this;
    }

     public function getMaterialNombre()
    {
        return $this->material_nombre;
    }

     public function setMaterialNombre($material_nombre)
    {
         $this->material_nombre = $material_nombre;
        return $this;
    }

      public function getCantidadUsar()
    {
        return $this->cantidad_usar;
    }

     public function setCantidadUsar($cantidad_usar)
    {
         $this->cantidad_usar = $cantidad_usar;
        return $this;
    }

     public function getPrecioTotal()
    {
        return $this->precio_total;
    }

     public function setPrecioTotal($precio_total)
    {
         $this->precio_total = $precio_total;
        return $this;
    }

      public function getEliminado()
    {
        return $this->eliminado;
    }

     public function setEliminado($eliminado)
    {
         $this->eliminado = $eliminado;
        return $this;
    }

     public function getFecha()
    {
        return $this->fecha;
    }

     public function setFecha($fecha)
    {
         $this->fecha = $fecha;
        return $this;
    }


}
