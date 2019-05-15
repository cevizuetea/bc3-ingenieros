<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TClienteRepository")
 */
class TCliente
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id_cliente;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nombre_cliente;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $direccion;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $telefono;

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
     * @ORM\OneToMany(targetEntity="App\Entity\TProyecto", mappedBy="cliente_id",  cascade={"persist"})
     */
    private $tProductos;

    public function __construct()
    {
        $this->tProductos = new ArrayCollection();
    }


    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    public function getNombreCliente()
    {
        return $this->nombre_cliente;
    }

     public function setNombreCliente($nombre_cliente)
    {
         $this->nombre_cliente = $nombre_cliente;
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
      * @return Collection|TProyecto[]
      */
     public function getTProductos(): Collection
     {
         return $this->tProductos;
     }

     public function addTProducto(TProyecto $tProducto): self
     {
         if (!$this->tProductos->contains($tProducto)) {
             $this->tProductos[] = $tProducto;
             $tProducto->setClienteId($this);
         }

         return $this;
     }

     public function removeTProducto(TProyecto $tProducto): self
     {
         if ($this->tProductos->contains($tProducto)) {
             $this->tProductos->removeElement($tProducto);
             // set the owning side to null (unless already changed)
             if ($tProducto->getClienteId() === $this) {
                 $tProducto->setClienteId(null);
             }
         }

         return $this;
     }
}
