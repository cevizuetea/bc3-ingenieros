<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass="App\Repository\TDetalleProyectoHerramientasRepository")
 */
class TDetalleProyectoHerramientas
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TProyecto", inversedBy="tDetalleProyectoHerramientas",  cascade={"persist"})
     * @ORM\JoinColumn(name="proyecto_id", referencedColumnName="id_proyecto", nullable=false)
     */
    private $proyecto_id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\THerramienta", inversedBy="tDetalleProyectoHerramientas", cascade={"persist"})
     * @ORM\JoinColumn(name="herramienta_id", referencedColumnName="id", nullable=false)
     */
    private $herramienta_id;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProyectoId(): ?TProyecto
    {
        return $this->proyecto_id;
    }

    public function setProyectoId(?TProyecto $proyecto_id): self
    {
        $this->proyecto_id = $proyecto_id;

        return $this;
    }

    public function getHerramientaId(): ?THerramienta
    {
        return $this->herramienta_id;
    }

    public function setHerramientaId(THerramienta $herramienta_id): self
    {
        $this->herramienta_id = $herramienta_id;

        return $this;
    }


    
}
