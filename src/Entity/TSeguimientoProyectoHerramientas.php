<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TSeguimientoProyectoHerramientasRepository")
 */
class TSeguimientoProyectoHerramientas
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
    private $herramientaid;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $codigo_herramienta; 

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $herramienta_nombre;

    /**
     * @ORM\Column(type="integer")
     */
    private $eliminado;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="integer")
     */
    private $estadoid = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

     public function getProyectoId()
    {
        return $this->proyectoid;
    }

     public function setProyectoId($proyectoid)
    {
         $this->proyectoid = $proyectoid;
        return $this;
    }

    public function getHerramientaId()
    {
        return $this->herramientaid;
    }

     public function setHerramientaId($herramientaid)
    {
         $this->herramientaid = $herramientaid;
        return $this;
    }

     public function getCodigoHerramienta()
    {
        return $this->codigo_herramienta;
    }

     public function setCodigoHerramienta($codigo_herramienta)
    {
         $this->codigo_herramienta = $codigo_herramienta;
        return $this;
    }

      public function getHerramientaNombre()
    {
        return $this->herramienta_nombre;
    }

     public function setHerramientaNombre($herramienta_nombre)
    {
         $this->herramienta_nombre = $herramienta_nombre;
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

    public function getEstadoId()
    {
        return $this->estadoid;
    }

     public function setEstadoId($estadoid)
    {
         $this->estadoid = $estadoid;
        return $this;
    }

}
