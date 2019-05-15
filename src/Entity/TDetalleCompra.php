<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TDetalleCompraRepository")
 */
class TDetalleCompra
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $codigo; 

    /**
     * @ORM\Column(type="integer")
     */
    private $cantidad;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $detalle; 

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $precio_unitario;

    /**
     * @ORM\Column(type="decimal",  scale=2, nullable=true)
     */
    private $precio_total = null;

     /**
     * @ORM\Column(type="string", length=25)
     */
    private $tipo;     

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TCompra", inversedBy="tDetalleCompra", cascade={"persist"})
     * @ORM\JoinColumn(name="compra_id", referencedColumnName="id", nullable=false)
     */
    private $compra_id;

    public function getId(): ?int
    {
        return $this->id;
    }

     public function getCodigo()
    {
        return $this->codigo;
    }

     public function setCodigo($codigo)
    {
         $this->codigo = $codigo;
        return $this;
    }

      public function getCantidad()
    {
        return $this->cantidad;
    }

     public function setCantidad($cantidad)
    {
         $this->cantidad = $cantidad;
        return $this;
    }

     public function getDetalle()
    {
        return $this->detalle;
    }

     public function setDetalle($detalle)
    {
         $this->detalle = $detalle;
        return $this;
    }

     public function getPrecioUnitario()
    {
        return $this->precio_unitario;
    }

     public function setPrecioUnitario($precio_unitario)
    {
         $this->precio_unitario = $precio_unitario;
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

    public function getTipo()
    {
        return $this->tipo;
    }

     public function setTipo($tipo)
    {
         $this->tipo = $tipo;
        return $this;
    }

    public function getCompraId(): ?TCompra
    {
        return $this->compra_id;
    }

    public function setCompraId(?TCompra $compra_id): self
    {
        $this->compra_id = $compra_id;

        return $this;
    }
}
