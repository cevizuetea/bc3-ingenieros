<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TCargoRepository")
 */
class TCargo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id_cargo;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $nombre_cargo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $rol;

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
    
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TTrabajadores", mappedBy="cargo_id", cascade={"persist"})
     */
    private $tTrabajadores;

    public function __construct()
    {
        $this->tTrabajadores = new ArrayCollection();
    }

    public function getIdCargo()
    {
        return $this->id_cargo;
    }

     public function setIdCargo($id_cargo)
    {
         $this->id_cargo = $id_cargo;
        return $this;
    }

     public function getNombreCargo()
    {
        return $this->nombre_cargo;
    }

     public function setNombreCargo($nombre_cargo)
    {
         $this->nombre_cargo = $nombre_cargo;
        return $this;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

     public function setDescripcion($descripcion)
    {
         $this->descripcion = $descripcion;
        return $this;
    }

    public function getRol()
    {
        return $this->rol;
    }

     public function setRol($rol)
    {
         $this->rol = $rol;
        return $this;
    }

    

     /**
      * @return Collection|TTrabajadores[]
      */
     public function getTTrabajadores(): Collection
     {
         return $this->tTrabajadores;
     }

     public function addTTrabajadore(TTrabajadores $tTrabajadore): self
     {
         if (!$this->tTrabajadores->contains($tTrabajadore)) {
             $this->tTrabajadores[] = $tTrabajadore;
             $tTrabajadore->setCargoId($this);
         }

         return $this;
     }

     public function removeTTrabajadore(TTrabajadores $tTrabajadore): self
     {
         if ($this->tTrabajadores->contains($tTrabajadore)) {
             $this->tTrabajadores->removeElement($tTrabajadore);
             // set the owning side to null (unless already changed)
             if ($tTrabajadore->getCargoId() === $this) {
                 $tTrabajadore->setCargoId(null);
             }
         }

         return $this;
     }
}
