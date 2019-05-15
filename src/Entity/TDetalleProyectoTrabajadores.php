<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TDetalleProyectoTrabajadoresRepository")
 */
class TDetalleProyectoTrabajadores
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TProyecto", inversedBy="tDetalleProyectoTrabajadores", cascade={"persist"})
     * @ORM\JoinColumn(name="idproyecto", referencedColumnName="id_proyecto", nullable=false)
     */
    private $idproyecto;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TTrabajadores", inversedBy="tDetalleProyectoTrabajadores", cascade={"persist"})
     * @ORM\JoinColumn(name="trabajador_id", referencedColumnName="id_trabajador", nullable=false)
     */
    private $trabajador_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdproyecto(): ?TProyecto
    {
        return $this->idproyecto;
    }

    public function setIdproyecto(?TProyecto $idproyecto): self
    {
        $this->idproyecto = $idproyecto;

        return $this;
    }

    public function getTrabajadorId(): ?TTrabajadores
    {
        return $this->trabajador_id;
    }

    public function setTrabajadorId(?TTrabajadores $trabajador_id): self
    {
        $this->trabajador_id = $trabajador_id;

        return $this;
    }
}
