<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Mime\MimeTypes;


/**
 * @ORM\Entity(repositoryClass="App\Repository\TProyectoRepository")
 */
class TProyecto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id_proyecto;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $nombre_proyecto;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $direccion_proyecto;
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Please, upload the product as a PDF file.")
     * @Assert\File(
     *     maxSize = "8Mi",
     *     mimeTypes = {"application/pdf", "application/x-pdf",
     *                    "application/x-rar-compressed","application/octet-stream", "application/zip"},
     *     maxSizeMessage = "Symfony: File too big!",
     *     mimeTypesMessage = "Symfony: Invalid file type!" 
     * )
     */
    private $archivo_cotizacion;
    
   

    /**
     * @ORM\Column(type="date")
     */
    private $Fecha_inicio;

    /**
     * @ORM\Column(type="date")
     */
    private $Fecha_fin;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TCliente", inversedBy="tProductos", cascade={"persist"})
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id_cliente", nullable=false)
     */
    private $cliente_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TTrabajadores", inversedBy="tProyecto", cascade={"persist"})
     * @ORM\JoinColumn(name="trabajador_id", referencedColumnName="id_trabajador", nullable=false)
     */
    private $trabajador_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TEstadoProyecto", inversedBy="tProyecto", cascade={"persist"})
     * @ORM\JoinColumn(name="estado_id", referencedColumnName="id_estado_proyecto", nullable=false)
     */
    private $estado_id;

    

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TDetalleProyectoHerramientas", mappedBy="proyecto_id", cascade={"persist"})
     */
    private $tDetalleProyectoHerramientas;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TDetalleProyectoMateriales", mappedBy="proyectoid")
     */
    private $tDetalleProyectoMateriales;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TAvanceProyecto", mappedBy="proyecto_id")
     */
    private $tAvanceProyectos;  
    

    public function __construct()
    {
        $this->tDetalleProyectoHerramientas = new ArrayCollection();
        $this->tDetalleProyectoMateriales = new ArrayCollection();
        $this->tAvanceProyectos = new ArrayCollection();
    }
 
    public function getImagenPortada()
    {
        return $this->imagen_portada;
    }

     public function setImagenPortada($imagen_portada)
    {
         $this->imagen_portada = $imagen_portada;
        return $this;
    }

     public function getIdProyecto(): ?int
    {
        return $this->id_proyecto;
    }

    public function getNombreProyecto()
    {
        return $this->nombre_proyecto;
    }

     public function setNombreProyecto($nombre_proyecto)
    {
         $this->nombre_proyecto = $nombre_proyecto;
        return $this;
    }

     public function getDireccionProyecto()
    {
        return $this->direccion_proyecto;
    }

     public function setDireccionProyecto($direccion_proyecto)
    {
         $this->direccion_proyecto = $direccion_proyecto;
        return $this;
    }

    public function getArchivoCotizacion()
    {
        return $this->archivo_cotizacion;
    }

     public function setArchivoCotizacion($archivo_cotizacion)
    {
         $this->archivo_cotizacion = $archivo_cotizacion;
        return $this;
    }

    public function getFechaInicio()
    {
        return $this->Fecha_inicio;
    }

     public function setFechaInicio($Fecha_inicio)
    {
         $this->Fecha_inicio = $Fecha_inicio;
        return $this;
    }   

     public function getFechaFin()
    {
        return $this->Fecha_fin;
    }

     public function setFechaFin($Fecha_fin)
    {
         $this->Fecha_fin = $Fecha_fin;
        return $this;
    }  

    public function getClienteId(): ?TCliente
    {
        return $this->cliente_id;
    }

    public function setClienteId(?TCliente $cliente_id): self
    {
        $this->cliente_id = $cliente_id;

        return $this;
    }

    public function getTrabajadorId(): ?TTrabajadores
    {
        return $this->trabajador_id;
    }

    public function setTrabajadorId(TTrabajadores $trabajador_id): self
    {
        $this->trabajador_id = $trabajador_id;

        return $this;
    }

    public function getEstadoId(): ?TEstadoProyecto
    {
        return $this->estado_id;
    }

    public function setEstadoId(TEstadoProyecto $estado_id): self
    {
        $this->estado_id = $estado_id;

        return $this;
    }

    /**
     * @return Collection|TDetalleProyectoHerramientas[]
     */
    public function getTDetalleProyectoHerramientas(): Collection
    {
        return $this->tDetalleProyectoHerramientas;
    }

    public function addTDetalleProyectoHerramienta(TDetalleProyectoHerramientas $tDetalleProyectoHerramienta): self
    {
        if (!$this->tDetalleProyectoHerramientas->contains($tDetalleProyectoHerramienta)) {
            $this->tDetalleProyectoHerramientas[] = $tDetalleProyectoHerramienta;
            $tDetalleProyectoHerramienta->setProyectoId($this);
        }

        return $this;
    }

    public function removeTDetalleProyectoHerramienta(TDetalleProyectoHerramientas $tDetalleProyectoHerramienta): self
    {
        if ($this->tDetalleProyectoHerramientas->contains($tDetalleProyectoHerramienta)) {
            $this->tDetalleProyectoHerramientas->removeElement($tDetalleProyectoHerramienta);
            // set the owning side to null (unless already changed)
            if ($tDetalleProyectoHerramienta->getProyectoId() === $this) {
                $tDetalleProyectoHerramienta->setProyectoId(null);
            }
        }

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
            $tDetalleProyectoMateriale->setProyectoid($this);
        }

        return $this;
    }

    public function removeTDetalleProyectoMateriale(TDetalleProyectoMateriales $tDetalleProyectoMateriale): self
    {
        if ($this->tDetalleProyectoMateriales->contains($tDetalleProyectoMateriale)) {
            $this->tDetalleProyectoMateriales->removeElement($tDetalleProyectoMateriale);
            // set the owning side to null (unless already changed)
            if ($tDetalleProyectoMateriale->getProyectoid() === $this) {
                $tDetalleProyectoMateriale->setProyectoid(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|TAvanceProyecto[]
     */
    public function getTAvanceProyectos(): Collection
    {
        return $this->tAvanceProyectos;
    }

    public function addTAvanceProyecto(TAvanceProyecto $tAvanceProyecto): self
    {
        if (!$this->tAvanceProyectos->contains($tAvanceProyecto)) {
            $this->tAvanceProyectos[] = $tAvanceProyecto;
            $tAvanceProyecto->setProyectoId($this);
        }

        return $this;
    }

    public function removeTAvanceProyecto(TAvanceProyecto $tAvanceProyecto): self
    {
        if ($this->tAvanceProyectos->contains($tAvanceProyecto)) {
            $this->tAvanceProyectos->removeElement($tAvanceProyecto);
            // set the owning side to null (unless already changed)
            if ($tAvanceProyecto->getProyectoId() === $this) {
                $tAvanceProyecto->setProyectoId(null);
            }
        }

        return $this;
    }

    

    
}
