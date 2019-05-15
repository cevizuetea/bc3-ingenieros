<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TProveedorRepository")
 */
class TProveedor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id_proveedor;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $nombre_proveedor;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $ruc;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $direccion;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $telefono;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TCompra", mappedBy="proveedor_id")
     */
    private $tCompras;

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
        $this->tCompras = new ArrayCollection();
    }


    public function getIdProveedor()
    {
        return $this->id_proveedor;
    }

     public function getNombreProveedor()
    {
        return $this->nombre_proveedor;
    }

     public function setNombreProveedor($nombre_proveedor)
    {
         $this->nombre_proveedor = $nombre_proveedor;
        return $this;
    }

     public function getRuc()
    {
        return $this->ruc;
    }

     public function setRuc($ruc)
    {
         $this->ruc = $ruc;
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

     /**
      * @return Collection|TCompra[]
      */
     public function getTCompras(): Collection
     {
         return $this->tCompras;
     }

     public function addTCompra(TCompra $tCompra): self
     {
         if (!$this->tCompras->contains($tCompra)) {
             $this->tCompras[] = $tCompra;
             $tCompra->setProveedorId($this);
         }

         return $this;
     }

     public function removeTCompra(TCompra $tCompra): self
     {
         if ($this->tCompras->contains($tCompra)) {
             $this->tCompras->removeElement($tCompra);
             // set the owning side to null (unless already changed)
             if ($tCompra->getProveedorId() === $this) {
                 $tCompra->setProveedorId(null);
             }
         }

         return $this;
     }
}

