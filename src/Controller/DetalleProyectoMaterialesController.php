<?php

namespace App\Controller;

use App\Entity\TDetalleProyectoMateriales;
use App\Entity\TProyecto;
use App\Entity\TCliente;
use App\Entity\TEstadoProyecto;
use App\Entity\TTrabajadores;
use App\Entity\TMaterial;
use App\Entity\TSeguimientoProyectoMateriales;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class DetalleProyectoMaterialesController extends AbstractController
{
     /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/asignar/materiales/{id}", name="detalle_proyecto_materiales")
     *@Method({"GET","POST"})
     */
    public function AsignarMateriales(Request $request, $id)
    {
    $proyectos = $this->getDoctrine()->getRepository(TProyecto::class)->find($id);
    $cliente = $this->getDoctrine()->getRepository(TCliente::class)->find($proyectos->getClienteId());
    $estados = $this->getDoctrine()->getRepository(TEstadoProyecto::class)->find($proyectos->getEstadoId());
    $trabajador = $this->getDoctrine()->getRepository(TTrabajadores::class)->find($proyectos->getTrabajadorId());

    $materialessasiganados = $this->getDoctrine()->getRepository(TDetalleProyectoMateriales::class)->findBy(
	array(
		'proyectoid' => $id
	));
	$materialesseguimiento = $this->getDoctrine()->getRepository(TSeguimientoProyectoMateriales::class)->findBy(
	array(
		'proyectoid' => $id,
		'eliminado' => 1
	));
	$detalle = new TDetalleProyectoMateriales($id);

    $form = $this->createFormBuilder($detalle)
	    ->add('proyectoid', EntityType::class, array(
	                'class' => TProyecto::class,
	                'query_builder' => function (EntityRepository $er) use ($id){
	                        return $er->createQueryBuilder('p')
	                        	->Where('p.id_proyecto = :idd')
	                        	->setParameter('idd', $id);                            
	                    },
	                'choice_label' => 'nombre_proyecto',
	            	))
	    ->add('materialid', EntityType::class, array(
	                'class' => TMaterial::class,
	                'query_builder' => function (EntityRepository $er){
                        return $er->createQueryBuilder('m')
                        	->Where('m.cantidad > 0');                            
                    },
                'choice_label' => 'codigomaterial',
                'label'=>'Código del material:'))
         ->add('cantidaduso', IntegerType::class, array('label' => 'Cantidad requerida:'), array('required' => false, 'attr' => array('class' => 'form-control')))    
        ->add('save', SubmitType::class, array('label' => 'Asignar', 'attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() )
        {
            $detalle = $form->getData();
            $errores=0;
            if($detalle->getCantidadUso() < 0)
                {
                    $errores = $errores+1;
                    $this->addFlash(
                    'error_cantidad',
                    '* No se permiten valores negativos');  
                }
            $materiales = $this->getDoctrine()->getRepository(TMaterial::class)->find($detalle->getMaterialid());

            if($detalle->getCantidadUso() > $materiales->getCantidad())
            {
                $errores = $errores+1;
                    $this->addFlash(
                    'error_uso',
                    '* La cantidad requerida sobrepasa de la existente'); 
            }
            if($errores == 0 && $form->isValid())
            {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($detalle);
            $entityManager->flush();
			$materiales = $this->getDoctrine()->getRepository(TMaterial::class)->find($detalle->getMaterialid());
            $idm = $materiales->getId();
            $cant = $detalle->getCantidadUso();
            $this->addFlash(
            'notice',
            'El material se asignó con éxito!');
       		return $this->redirectToRoute('disminuir_stock', array('idm' => $idm,'id' => $id, 'cant' => $cant));
            }
        }
    
       return $this->render('proyecto/asignar_materiales.html.twig', array('proyectos' => $proyectos,'cliente' => $cliente, 'estados' => $estados, 'trabajador' => $trabajador, 'materialesseguimiento' => $materialesseguimiento, 'form' => $form->createView() )); 
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/disminuir/material/stock/{idm}/{id}/{cant}", name="disminuir_stock")
     *@Method({"GET","POST"})
     */
     public function EditarMaterialStock($idm, $id, $cant)
     {
     	$entityManager = $this->getDoctrine()->getManager();
     	$materiales = $entityManager->getRepository(TMaterial::class)->find($idm);
     	if(!$materiales)
        {
	    	throw $this->createNotFoundException("Error Processing Request", $idm);     	    	
   	    }
   	    $cantidad = $materiales->getCantidad() - $cant;
   	    $materiales->setCantidad($cantidad);
   	    $materiales->setPrecioTotal($cantidad * $materiales->getPrecioUnitario());
   	    $entityManager->flush();
   		return $this->redirectToRoute('seguimiento_material', array('idm' => $idm,'id' => $id, 'cant' => $cant));
     }

      //Asignar a seguimiento
     /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/asignar/materiales/seguimiento/{idm}/{id}/{cant}", name="seguimiento_material")
     *@Method({"GET","POST"})
     */
     public function AsignarMaterialSeguimiento($idm, $id, $cant)
     {
     	    $entityManager = $this->getDoctrine()->getManager();
     	    $seguimientomaterial = $entityManager->getRepository(TMaterial::class)->find($idm);
	    	  $seguimiento = new TSeguimientoProyectoMateriales();
	          $seguimiento->setProyectoid($id);
	          $seguimiento->setMaterialId($idm);
	          $seguimiento->setCodigomaterial($seguimientomaterial->getCodigoMaterial());
	          $seguimiento->setMaterialNombre($seguimientomaterial->getNombreMaterial());
	          $seguimiento->setCantidadUsar($cant);
	          $seguimiento->setPrecioTotal($seguimientomaterial->getPrecioUnitario() * $cant);
	          $seguimiento->setEliminado(1);
              $seguimiento->setFecha(new \DateTime());
		     $entityManager->persist($seguimiento);
     	     $entityManager->flush();
     	     return $this->redirectToRoute('detalle_proyecto_materiales', array('id' => $id));
     }
     //fin asig seguimiento

     /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/editar/material/seguimiento/{idm}/{id}/{cant}", name="editar_material_seguimiento")
     *@Method({"GET","POST"})
     */
     public function EditarMaterialDetalle($idm, $id, $cant)
     {
     	    $entityManager = $this->getDoctrine()->getManager();
     	    $materiales = $entityManager->getRepository(TMaterial::class)->find($idm);     	    

     	    if(!$materiales)
     	    {
     	    	throw $this->createNotFoundException("Error Processing Request", $idm);     	    	
     	    }
			$cantidad = $materiales->getCantidad() + $cant;
     	    $materiales->setCantidad($cantidad);
     	    $materiales->setPrecioTotal($cantidad * $materiales->getPrecioUnitario());   
     	    $entityManager->flush();
     	    $entityManager = $this->getDoctrine()->getManager();
     	    $materialesproyctoseguimiento = $entityManager->getRepository(TSeguimientoProyectoMateriales::class)->findOneBy(
			array(
				'proyectoid' => $id,
				'material_id' => $idm,
				'eliminado' => 1,
			));
     	    $materialesproyctoseguimiento->setEliminado(0);
     	    $entityManager->flush();
       		return $this->redirectToRoute('eliminar_material_detalle', array('idm' => $idm, 'id' => $id));
     }

     /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/eliminar/material/detalle/{idm}/{id}", name="eliminar_material_detalle")
     *@Method({"GET","POST"})
     */
     public function EliminarMaterialDetalle($idm, $id)
     {
     	$entityManager = $this->getDoctrine()->getManager();
     	$eliminarmaterial = $entityManager->getRepository(TDetalleProyectoMateriales::class)->findBy(
		array(
			'proyectoid' => $id,
			'material_id' => $idm
		));
     	foreach ($eliminarmaterial as $eliminarmateriales) {
		    $entityManager->remove($eliminarmateriales);
		}
		$entityManager->flush();
       	return $this->redirectToRoute('detalle_proyecto_materiales', array('id' => $id));
     }
}
