<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TMaterialRepository")
 */
class TMaterial
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
    private $codigo_material;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nombre_material;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $descripcion_material;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantidad;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $precio_unitario;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=true)
     */
    private $precio_total = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TMarcab", inversedBy="tMaterials", cascade={"persist"})
     * @ORM\JoinColumn(name="marcaid", referencedColumnName="id", nullable=false)
     */
    private $marcaid;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TDetalleProyectoMateriales", mappedBy="material_id")
     */
    private $tDetalleProyectoMateriales;

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
        $this->tDetalleProyectoMateriales = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

     public function getCodigoMaterial()
    {
        return $this->codigo_material;
    }

     public function setCodigoMaterial($codigo_material)
    {
         $this->codigo_material = $codigo_material;
        return $this;
    }

    public function getNombreMaterial()
    {
        return $this->nombre_material;
    }

     public function setNombreMaterial($nombre_material)
    {
         $this->nombre_material = $nombre_material;
        return $this;
    }

    public function getDescripcionMaterial()
    {
        return $this->descripcion_material;
    }

     public function setDescripcionMaterial($descripcion_material)
    {
         $this->descripcion_material = $descripcion_material;
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





    //rRELACCION CON MARCA

    public function getMarcaid(): ?TMarcab
    {
        return $this->marcaid;
    }

    public function setMarcaid(?TMarcab $marcaid): self
    {
        $this->marcaid = $marcaid;

        return $this;
    }

    /**
     * @return Collection|TDetalleProyectoMateriales[]
     */
    public function getTDetalleProyectoMateriales(): Collection
    {
        return $this->tDetalleProyectoMateriales;
    }

    public function addTDetalleProyectoMateriale(TDetalleProyectoMateriales $tDetalleProyectoMateriale): self
    {
        if (!$this->tDetalleProyectoMateriales->contains($tDetalleProyectoMateriale)) {
            $this->tDetalleProyectoMateriales[] = $tDetalleProyectoMateriale;
            $tDetalleProyectoMateriale->setMaterialId($this);
        }

        return $this;
    }

    public function removeTDetalleProyectoMateriale(TDetalleProyectoMateriales $tDetalleProyectoMateriale): self
    {
        if ($this->tDetalleProyectoMateriales->contains($tDetalleProyectoMateriale)) {
            $this->tDetalleProyectoMateriales->removeElement($tDetalleProyectoMateriale);
            // set the owning side to null (unless already changed)
            if ($tDetalleProyectoMateriale->getMaterialId() === $this) {
                $tDetalleProyectoMateriale->setMaterialId(null);
            }
        }

        return $this;
    }
}
