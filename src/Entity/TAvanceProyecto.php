<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TAvanceProyectoRepository")
 */
class TAvanceProyecto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=350)
     * @Assert\NotBlank(message="Please, upload a PDF file.")
     * @Assert\File(
     *     maxSize = "6M",
     *     mimeTypes = {"application/pdf", "application/x-pdf",
     *                    "application/x-rar-compressed","application/octet-stream", "application/zip"},
     *     maxSizeMessage = "Symfony: File too big!",
     *     mimeTypesMessage = "Symfony: Invalid file type!" 
     * )
    */
    private $archivo_avance;
    
    /**
     * @ORM\Column(type="date")
     */
    private $fecha_avance;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $observaciones = null;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TProyecto", inversedBy="tAvanceProyectos")
     * @ORM\JoinColumn(name="proyecto_id", referencedColumnName="id_proyecto", nullable=false)
     */
    private $proyecto_id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TGaleriaProyecto", mappedBy="avance_id")
     */
    private $tGaleriaProyectos;

    public function __construct()
    {
        $this->tGaleriaProyectos = new ArrayCollection();
    }

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

    public function getArchivoAvance()
    {
        return $this->archivo_avance;
    }

     public function setArchivoAvance($archivo_avance)
    {
         $this->archivo_avance = $archivo_avance;
        return $this;
    }

    public function getFechaAvance()
    {
        return $this->fecha_avance;
    }

     public function setFechaAvance($fecha_avance)
    {
         $this->fecha_avance = $fecha_avance;
        return $this;
    }

    public function getObservaciones()
    {
        return $this->observaciones;
    }

     public function setObservaciones($observaciones)
    {
         $this->observaciones = $observaciones;
        return $this;
    }

     /**
      * @return Collection|TGaleriaProyecto[]
      */
     public function getTGaleriaProyectos(): Collection
     {
         return $this->tGaleriaProyectos;
     }

     public function addTGaleriaProyecto(TGaleriaProyecto $tGaleriaProyecto): self
     {
         if (!$this->tGaleriaProyectos->contains($tGaleriaProyecto)) {
             $this->tGaleriaProyectos[] = $tGaleriaProyecto;
             $tGaleriaProyecto->setAvanceId($this);
         }

         return $this;
     }

     public function removeTGaleriaProyecto(TGaleriaProyecto $tGaleriaProyecto): self
     {
         if ($this->tGaleriaProyectos->contains($tGaleriaProyecto)) {
             $this->tGaleriaProyectos->removeElement($tGaleriaProyecto);
             // set the owning side to null (unless already changed)
             if ($tGaleriaProyecto->getAvanceId() === $this) {
                 $tGaleriaProyecto->setAvanceId(null);
             }
         }

         return $this;
     } 
}
