<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\THerramientaRepository")
 */
class THerramienta
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
    private $codigo; 

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nombre_herramienta;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $descripcion_herramienta;

    /**
     * @ORM\Column(type="integer")
     */
    private $ocupado = 0;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TMarcab", inversedBy="tHerramientas")
     * @ORM\JoinColumn(name="marca_id", referencedColumnName="id", nullable=false)
     */
    private $marca_id;

    /** 
     * @ORM\ManyToOne(targetEntity="App\Entity\TEstadoBodega", inversedBy="tHerramientas")
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id_estado",nullable=false)
     */
    private $estado_id;

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
     * @ORM\OneToOne(targetEntity="App\Entity\TDetalleProyectoHerramientas", mappedBy="herramienta_id", cascade={"persist"})
     */
    private $tDetalleProyectoHerramientas;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TTipoBodega", inversedBy="tHerramientas")
     * @ORM\JoinColumn(name="tipo_id", referencedColumnName="id_tipo", nullable=false)
     */
    private $tipo_id;

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

    public function getNombreHerramienta()
    {
        return $this->nombre_herramienta;
    }

     public function setNombreHerramienta($nombre_herramienta)
    {
         $this->nombre_herramienta = $nombre_herramienta;
        return $this;
    }

    public function getDescripcionHerramienta()
    {
        return $this->descripcion_herramienta;
    }

     public function setDescripcionHerramienta($descripcion_herramienta)
    {
         $this->descripcion_herramienta = $descripcion_herramienta;
        return $this;
    }

    public function getOcupado()
    {
        return $this->ocupado;
    }

     public function setOcupado($ocupado)
    {
         $this->ocupado = $ocupado;
        return $this;
    }








    public function getMarcaId(): ?TMarcab
    {
        return $this->marca_id;
    }

    public function setMarcaId(?TMarcab $marca_id): self
    {
        $this->marca_id = $marca_id;

        return $this;
    }

    public function getEstadoId(): ?TEstadoBodega
    {
        return $this->estado_id;
    }

    public function setEstadoId(?TEstadoBodega $estado_id): self
    {
        $this->estado_id = $estado_id;

        return $this;
    }

    public function getTDetalleProyectoHerramientas(): ?TDetalleProyectoHerramientas
    {
        return $this->tDetalleProyectoHerramientas;
    }

    public function setTDetalleProyectoHerramientas(TDetalleProyectoHerramientas $tDetalleProyectoHerramientas): self
    {
        $this->tDetalleProyectoHerramientas = $tDetalleProyectoHerramientas;

        // set the owning side of the relation if necessary
        if ($this !== $tDetalleProyectoHerramientas->getHerramientaId()) {
            $tDetalleProyectoHerramientas->setHerramientaId($this);
        }

        return $this;
    }

    public function getTipoId(): ?TTipoBodega
    {
        return $this->tipo_id;
    }

    public function setTipoId(?TTipoBodega $tipo_id): self
    {
        $this->tipo_id = $tipo_id;

        return $this;
    }


    
}
