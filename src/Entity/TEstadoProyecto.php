<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TEstadoProyectoRepository")
 */
class TEstadoProyecto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
     private $id_estado_proyecto;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nombre_estado_proyecto;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descripcion_estado_proyecto;

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
     * @ORM\OneToMany(targetEntity="App\Entity\TProyecto", mappedBy="estado_id", cascade={"persist"})
     */
    private $tProyecto;

    public function getIdEstadoProyecto()
    {
        return $this->id_estado_proyecto;
    }

     public function getNombreEstadoProyecto()
    {
        return $this->nombre_estado_proyecto;
    }

     public function setNombreEstadoProyecto($nombre_estado_proyecto)
    {
         $this->nombre_estado_proyecto = $nombre_estado_proyecto;
        return $this;
    }

    public function getDescripcionEstadoProyecto()
    {
        return $this->descripcion_estado_proyecto;
    }

     public function setDescripcionEstadoProyecto($descripcion_estado_proyecto)
    {
         $this->descripcion_estado_proyecto = $descripcion_estado_proyecto;
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
         if ($this !== $tProyecto->getEstadoId()) {
             $tProyecto->setEstadoId($this);
         }

         return $this;
     }
}
