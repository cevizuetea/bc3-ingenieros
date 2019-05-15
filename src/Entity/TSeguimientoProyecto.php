<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TSeguimientoProyectoRepository")
 */
class TSeguimientoProyecto
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
    private $estadoid = 0;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

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

    public function getEstadoId()
    {
        return $this->estadoid;
    }

     public function setEstadoId($estadoid)
    {
         $this->estadoid = $estadoid;
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
