<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TTipoBodegaRepository")
 */
class TTipoBodega
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id_tipo;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nombre_tipo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion_tipo;

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
     * @ORM\OneToMany(targetEntity="App\Entity\THerramienta", mappedBy="tipo_id")
     */
    private $tHerramientas;

    public function __construct()
    {
        $this->tHerramientas = new ArrayCollection();
    }

    public function getIdTipo()
    {
        return $this->id_tipo;
    }

     public function getNombreTipo()
    {
        return $this->nombre_tipo;
    }

     public function setNombreTipo($nombre_tipo)
    {
         $this->nombre_tipo = $nombre_tipo;
        return $this;
    }

    public function getDescripcionTipo()
    {
        return $this->descripcion_tipo;
    }

     public function setDescripcionTipo($descripcion_tipo)
    {
         $this->descripcion_tipo = $descripcion_tipo;
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
             $tHerramienta->setTipoId($this);
         }

         return $this;
     }

     public function removeTHerramienta(THerramienta $tHerramienta): self
     {
         if ($this->tHerramientas->contains($tHerramienta)) {
             $this->tHerramientas->removeElement($tHerramienta);
             // set the owning side to null (unless already changed)
             if ($tHerramienta->getTipoId() === $this) {
                 $tHerramienta->setTipoId(null);
             }
         }

         return $this;
     }
}
