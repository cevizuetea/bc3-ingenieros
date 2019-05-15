<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TGaleriaProyectoRepository")
 */
class TGaleriaProyecto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Please, upload the product as a Image file.")
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" })
     */
    private $nombre_imagen;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $descripcion = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TAvanceProyecto", inversedBy="tGaleriaProyectos")
     * @ORM\JoinColumn(name="avance_id", referencedColumnName="id", nullable=false)
     */
    private $avance_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombreImagen()
    {
        return $this->nombre_imagen;
    }

     public function setNombreImagen($nombre_imagen)
    {
         $this->nombre_imagen = $nombre_imagen;
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

    public function getAvanceId(): ?TAvanceProyecto
    {
        return $this->avance_id;
    }

    public function setAvanceId(?TAvanceProyecto $avance_id): self
    {
        $this->avance_id = $avance_id;

        return $this;
    }


}
