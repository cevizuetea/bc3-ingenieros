<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TDetalleProyectoMaterialesRepository")
 */
class TDetalleProyectoMateriales
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TProyecto", inversedBy="tDetalleProyectoMateriales", cascade={"persist"} )
     * @ORM\JoinColumn(name="proyectoid", referencedColumnName="id_proyecto", nullable=false)
     */
    private $proyectoid;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TMaterial", inversedBy="tDetalleProyectoMateriales", cascade={"persist"})
     * @ORM\JoinColumn(name="material_id", referencedColumnName="id",nullable=false)
     */
    private $material_id;

     /**
     * @ORM\Column(type="integer")
     */
    private $cantidad_uso;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCantidadUso()
    {
        return $this->cantidad_uso;
    }

     public function setCantidadUso($cantidad_uso)
    {
         $this->cantidad_uso = $cantidad_uso;
        return $this;
    }


    //RELACION CON PROYECTO

    public function getProyectoid(): ?TProyecto
    {
        return $this->proyectoid;
    }

    public function setProyectoid(?TProyecto $proyectoid): self
    {
        $this->proyectoid = $proyectoid;

        return $this;
    }

    //RELACION CON MATERIAL

    public function getMaterialId(): ?TMaterial
    {
        return $this->material_id;
    }

    public function setMaterialId(?TMaterial $material_id): self
    {
        $this->material_id = $material_id;

        return $this;
    }
}
