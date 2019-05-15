<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TMarcabRepository")
 */
class TMarcab
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $nombre_marca;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\THerramienta", mappedBy="marca_id")
     */
    private $tHerramientas;

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
     * @ORM\OneToMany(targetEntity="App\Entity\TMaterial", mappedBy="marcaid")
     */
    private $tMaterials;

    public function __construct()
    {
        $this->tHerramientas = new ArrayCollection();
        $this->tMaterials = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

     public function getNombreMarca()
    {
        return $this->nombre_marca;
    }

     public function setNombreMarca($nombre_marca)
    {
         $this->nombre_marca = $nombre_marca;
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

     /**
      * @return Collection|THerramienta[]
      */
     public function getTHerramientas(): Collection
     {
         return $this->tHerramientas;
     }

     public function addTHerramienta(THerramienta $tHerramienta): self
     {
         if (!$this->tHerramientas->contains($tHerramienta)) {
             $this->tHerramientas[] = $tHerramienta;
             $tHerramienta->setMarcaId($this);
         }

         return $this;
     }

     public function removeTHerramienta(THerramienta $tHerramienta): self
     {
         if ($this->tHerramientas->contains($tHerramienta)) {
             $this->tHerramientas->removeElement($tHerramienta);
             // set the owning side to null (unless already changed)
             if ($tHerramienta->getMarcaId() === $this) {
                 $tHerramienta->setMarcaId(null);
             }
         }

         return $this;
     }

     /**
      * @return Collection|TMaterial[]
      */
     public function getTMaterials(): Collection
     {
         return $this->tMaterials;
     }

     public function addTMaterial(TMaterial $tMaterial): self
     {
         if (!$this->tMaterials->contains($tMaterial)) {
             $this->tMaterials[] = $tMaterial;
             $tMaterial->setMarcaid($this);
         }

         return $this;
     }

     public function removeTMaterial(TMaterial $tMaterial): self
     {
         if ($this->tMaterials->contains($tMaterial)) {
             $this->tMaterials->removeElement($tMaterial);
             // set the owning side to null (unless already changed)
             if ($tMaterial->getMarcaid() === $this) {
                 $tMaterial->setMarcaid(null);
             }
         }

         return $this;
     }
}
