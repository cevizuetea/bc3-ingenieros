<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TSeguimientoProyectoTrabajadoresRepository")
 */
class TSeguimientoProyectoTrabajadores
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
    private $trabajadorid;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $cedula_trabajador; 

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $nombres_trabajador;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $apellidos_trabajador;

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

     public function getTrabajadorid()
    {
        return $this->trabajadorid;
    }

     public function setTrabajadorid($trabajadorid)
    {
         $this->trabajadorid = $trabajadorid;
        return $this;
    }

    public function getCedulaTrabajador()
    {
        return $this->cedula_trabajador;
    }

     public function setCedulaTrabajador($cedula_trabajador)
    {
         $this->cedula_trabajador = $cedula_trabajador;
        return $this;
    }

    public function getNombresTrabajador()
    {
        return $this->nombres_trabajador;
    }

     public function setNombresTrabajador($nombres_trabajador)
    {
         $this->nombres_trabajador = $nombres_trabajador;
        return $this;
    }

     public function getApellidosTrabajador()
    {
        return $this->apellidos_trabajador;
    }

     public function setApellidosTrabajador($apellidos_trabajador)
    {
         $this->apellidos_trabajador = $apellidos_trabajador;
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
