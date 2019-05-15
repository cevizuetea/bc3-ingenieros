<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TCompraRepository")
 */
class TCompra
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

     /**
     * @ORM\Column(type="string", length=15)
     */
    private $numero_factura; 

     /**
     * @ORM\Column(type="date")
     */
    private $fecha_emision;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    private $sub_total = null;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    private $iva = 0;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    private $total = 0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TProveedor", inversedBy="tCompras", cascade={"persist"})
     * @ORM\JoinColumn(name="proveedor_id", referencedColumnName="id_proveedor", nullable=false)
     */
    private $proveedor_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TDetalleCompra", mappedBy="compra_id")
     */
    private $tDetalleCompra;

    public function __construct()
    {
        $this->tDetalleCompra = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }


     public function getNumeroFactura()
    {
        return $this->numero_factura;
    }

     public function setNumeroFactura($numero_factura)
    {
         $this->numero_factura = $numero_factura;
        return $this;
    }

     public function getFechaEmision()
    {
        return $this->fecha_emision;
    }

     public function setFechaEmision($fecha_emision)
    {
         $this->fecha_emision = $fecha_emision;
        return $this;
    } 

     public function getSubTotal()
    {
        return $this->sub_total;
    }

     public function setSubTotal($sub_total)
    {
         $this->sub_total = $sub_total;
        return $this;
    }

     public function getIva()
    {
        return $this->iva;
    }

     public function setIva($iva)
    {
         $this->iva = $iva;
        return $this;
    }

     public function getTotal()
    {
        return $this->total;
    }

     public function setTotal($total)
    {
         $this->total = $total;
        return $this;
    }


    public function getProveedorId(): ?TProveedor
    {
        return $this->proveedor_id;
    }

    public function setProveedorId(?TProveedor $proveedor_id): self
    {
        $this->proveedor_id = $proveedor_id;

        return $this;
    }

    /**
     * @return Collection|TDetalleCompra[]
     */
    public function getTDetalleCompra(): Collection
    {
        return $this->tDetalleCompra;
    }

    public function addTDetalleCompra(TDetalleCompra $tDetalleCompra): self
    {
        if (!$this->tDetalleCompra->contains($tDetalleCompra)) {
            $this->tDetalleCompra[] = $tDetalleCompra;
            $tDetalleCompra->setCompraId($this);
        }

        return $this;
    }

    public function removeTDetalleCompra(TDetalleCompra $tDetalleCompra): self
    {
        if ($this->tDetalleCompra->contains($tDetalleCompra)) {
            $this->tDetalleCompra->removeElement($tDetalleCompra);
            // set the owning side to null (unless already changed)
            if ($tDetalleCompra->getCompraId() === $this) {
                $tDetalleCompra->setCompraId(null);
            }
        }

        return $this;
    }
}
