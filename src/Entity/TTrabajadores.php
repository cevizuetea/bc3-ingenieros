<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TTrabajadoresRepository")
 */
class TTrabajadores
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id_trabajador;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $ci;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nombres;

     /**
     * @ORM\Column(type="string", length=100)
     */
    private $apellidos;

     /**
     * @ORM\Column(type="integer")
     */
    private $edad;

     /**
     * @ORM\Column(type="string", length=200)
     */
    private $direccion;

     /**
     * @ORM\Column(type="string", length=20)
     */
    private $telefono;

     /**
     * @ORM\Column(type="date")
     */
    private $fecha_ingreso;

     /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TCargo", inversedBy="tTrabajadores", cascade={"persist"})
     * @ORM\JoinColumn(name="cargo_id", referencedColumnName="id_cargo", nullable=false)
     */
    private $cargo_id;
    
    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $sueldo;

     /**
     * @ORM\Column(type="date")
     */
    private $fecha_salida;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TProyecto", mappedBy="trabajador_id", cascade={"persist"})
     */
    private $tProyecto;

    /** 
     * @ORM\OneToMany(targetEntity="App\Entity\TDetalleProyectoTrabajadores", mappedBy="trabajador_id")
     */
    private $tDetalleProyectoTrabajadores;

    /**
     * @ORM\Column(type="integer" )
     */
    private $disponibilidad = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $eliminado = 0;

    public function getEliminado()
    {
        return $this->eliminado;
    }

     public function setEliminado($eliminado)
    {
         $this->eliminado = $eliminado;
        return $this;
    }
    

    public function __construct()
    {
        $this->tDetalleProyectoTrabajadores = new ArrayCollection();
    }   



    public function getIdTrabajador(): ?int
    {
        return $this->id_trabajador;
    }

    public function getCi()
    {
        return $this->ci;
    }

     public function setCi($ci)
    {
         $this->ci = $ci;
        return $this;
    }

     public function getNombres()
    {
        return $this->nombres;
    }

     public function setNombres($nombres)
    {
         $this->nombres = $nombres;
        return $this;
    }

     public function getApellidos()
    {
        return $this->apellidos;
    }

     public function setApellidos($apellidos)
    {
         $this->apellidos = $apellidos;
        return $this;
    }

     public function getEdad()
    {
        return $this->edad;
    }

     public function setEdad($edad)
    {
         $this->edad = $edad;
        return $this;
    }

    public function getDireccion()
    {
        return $this->direccion;
    }

     public function setDireccion($direccion)
    {
         $this->direccion = $direccion;
        return $this;
    }

     public function getTelefono()
    {
        return $this->telefono;
    }

     public function setTelefono($telefono)
    {
         $this->telefono = $telefono;
        return $this;
    }
    
     public function getFechaIngreso()
    {
        return $this->fecha_ingreso;
    }

     public function setFechaIngreso($fecha_ingreso)
    {
         $this->fecha_ingreso = $fecha_ingreso;
        return $this;
    }    

    public function getCargoId(): ?TCargo
    {
        return $this->cargo_id;
    }

    public function setCargoId(?TCargo $cargo_id): self
    {
        $this->cargo_id = $cargo_id;

        return $this;
    }

    public function getSueldo()
    {
        return $this->sueldo;
    }

     public function setSueldo($sueldo)
    {
         $this->sueldo = $sueldo;
        return $this;
    }  

    public function getFechaSalida()
    {
        return $this->fecha_salida;
    }

     public function setFechaSalida($fecha_salida)
    {
         $this->fecha_salida = $fecha_salida;
        return $this;
    }

     public function getTProyecto(): ?TProyecto
     {
         return $this->tProyecto;
     }

     public function setTProyecto(TProyecto $tProyecto): self
     {
         $this->tProyecto = $tProyecto;

         // set the owning side of the relation if necessary
         if ($this !== $tProyecto->getTrabajadorId()) {
             $tProyecto->setTrabajadorId($this);
         }

         return $this;
     }

     /**
      * @return Collection|TDetalleProyectoTrabajadores[]
      */
     public function getTDetalleProyectoTrabajadores(): Collection
     {
         return $this->tDetalleProyectoTrabajadores;
     }

     public function addTDetalleProyectoTrabajadore(TDetalleProyectoTrabajadores $tDetalleProyectoTrabajadore): self
     {
         if (!$this->tDetalleProyectoTrabajadores->contains($tDetalleProyectoTrabajadore)) {
             $this->tDetalleProyectoTrabajadores[] = $tDetalleProyectoTrabajadore;
             $tDetalleProyectoTrabajadore->setTrabajadorId($this);
         }

         return $this;
     }

     public function removeTDetalleProyectoTrabajadore(TDetalleProyectoTrabajadores $tDetalleProyectoTrabajadore): self
     {
         if ($this->tDetalleProyectoTrabajadores->contains($tDetalleProyectoTrabajadore)) {
             $this->tDetalleProyectoTrabajadores->removeElement($tDetalleProyectoTrabajadore);
             // set the owning side to null (unless already changed)
             if ($tDetalleProyectoTrabajadore->getTrabajadorId() === $this) {
                 $tDetalleProyectoTrabajadore->setTrabajadorId(null);
             }
         }

         return $this;
     }  

     public function getDisponibilidad()
    {
        return $this->disponibilidad;
    }

     public function setDisponibilidad($disponibilidad)
    {
         $this->disponibilidad = $disponibilidad;
        return $this;
    }


}
