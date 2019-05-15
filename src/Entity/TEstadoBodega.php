<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TEstadoBodegaRepository")
 */
class TEstadoBodega
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id_estado;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nombre_estado;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion_estado;

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
     * @ORM\OneToMany(targetEntity="App\Entity\THerramienta", mappedBy="estado_id", cascade={"persist"})
     */
    private $tHerramientas;

    public function __construct()
    {
        $this->tHerramientas = new ArrayCollection();
    }

    public function getIdEstado()
    {
        return $this->id_estado;
    }

     public function getNombreEstado()
    {
        return $this->nombre_estado;
    }

     public function setNombreEstado($nombre_estado)
    {
         $this->nombre_estado = $nombre_estado;
        return $this;
    }

    public function getDescripcionEstado()
    {
        return $this->descripcion_estado;
    }

     public function setDescripcionEstado($descripcion_estado)
    {
         $this->descripcion_estado = $descripcion_estado;
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
             $tHerramienta->setEstadoId($this);
         }

         return $this;
     }

     public function removeTHerramienta(THerramienta $tHerramienta): self
     {
         if ($this->tHerramientas->contains($tHerramienta)) {
             $this->tHerramientas->removeElement($tHerramienta);
             // set the owning side to null (unless already changed)
             if ($tHerramienta->getEstadoId() === $this) {
                 $tHerramienta->setEstadoId(null);
             }
         }

         return $this;
     }
}
