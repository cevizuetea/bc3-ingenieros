<?php

namespace App\Controller;

use App\Entity\TDetalleProyectoHerramientas;
use App\Entity\TProyecto;
use App\Entity\TCliente;
use App\Entity\TEstadoProyecto;
use App\Entity\TTrabajadores;
use App\Entity\THerramienta;
use App\Entity\TEstadoBodega;
use App\Entity\TSeguimientoProyectoHerramientas;

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

class DetalleProyectoHerramientasController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/asignar/herramientas/{id}", name="detalle_proyecto_herramientas")
     *@Method({"GET","POST"})
     */
    public function AsignarHerramientas(Request $request, $id)
    {
    $proyectos = $this->getDoctrine()->getRepository(TProyecto::class)->find($id);
    $cliente = $this->getDoctrine()->getRepository(TCliente::class)->find($proyectos->getClienteId());
    $estados = $this->getDoctrine()->getRepository(TEstadoProyecto::class)->find($proyectos->getEstadoId());
    $trabajador = $this->getDoctrine()->getRepository(TTrabajadores::class)->find($proyectos->getTrabajadorId());

    $herramientasasiganadas = $this->getDoctrine()->getRepository(TDetalleProyectoHerramientas::class)->findBy(
	array(
		'proyecto_id' => $id
	));

	$herramientasasseguimiento = $this->getDoctrine()->getRepository(TSeguimientoProyectoHerramientas::class)->findBy(
	array(
		'proyectoid' => $id,
		'eliminado' => 1,
	));
    $detalle = new TDetalleProyectoHerramientas($id);

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
    ->add('herramientaid', EntityType::class, array(
                'class' => THerramienta::class,
                'query_builder' => function (EntityRepository $er){
                        return $er->createQueryBuilder('h')
                        	->Where('h.ocupado = 0');                            
                    },
                'choice_label' => 'codigo',
                'label'=>'Código de la herramienta:'))
    ->add('save', SubmitType::class, array('label' => 'Asignar', 'attr' => array('class' => 'btn btn-success mt-3')))
    ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $detalle = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($detalle);
            $entityManager->flush();
            $herramientas = $this->getDoctrine()->getRepository(THerramienta::class)->find($detalle->getHerramientaId());
            $idh = $herramientas->getId();
            $this->addFlash(
            'notice',
            'La herramienta se asignó con éxito!'
            );
       		return $this->redirectToRoute('editar_herramienta_ocupado', array('idh' => $idh,'id' => $id));
        }   
       return $this->render('proyecto/asignar_herramientas.html.twig', array('proyectos' => $proyectos,'cliente' => $cliente, 'estados' => $estados, 'trabajador' => $trabajador, 'herramientasasiganadas' => $herramientasasiganadas, 'herramientasasseguimiento' => $herramientasasseguimiento, 'form' => $form->createView())); 
    }

     /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/editar/herramienta/ocupado/{idh}/{id}", name="editar_herramienta_ocupado")
     *@Method({"GET","POST"})
    */
     public function EditarHerramientaOcupado($idh, $id)
     {
     	$entityManager = $this->getDoctrine()->getManager();
     	$herramientas = $entityManager->getRepository(THerramienta::class)->find($idh);
     	if(!$herramientas)
     	{
     	  	throw $this->createNotFoundException("Error Processing Request", $idh);     	    	
     	}
     	$herramientas->setOcupado(1);
     	$entityManager->flush();
       	return $this->redirectToRoute('seguimiento_herramienta', array('idh' => $idh, 'id' => $id));
     }

     //Asignar a seguimiento
     /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/asignar/herramienta/seguimiento/{idh}/{id}", name="seguimiento_herramienta")
     *@Method({"GET","POST"})
     */
     public function AsignarHerramientaSeguimiento($idh, $id)
     {
     	$entityManager = $this->getDoctrine()->getManager();
     	$seguimientoherramienta = $entityManager->getRepository(THerramienta::class)->find($idh);
        $estadobodega = $entityManager->getRepository(TEstadoBodega::class)->find($seguimientoherramienta->getEstadoId());
	    $seguimiento = new TSeguimientoProyectoHerramientas();
	    $seguimiento->setProyectoId($id);
	    $seguimiento->setHerramientaId($idh);
	    $seguimiento->setCodigoHerramienta($seguimientoherramienta->getCodigo());
	    $seguimiento->setHerramientaNombre($seguimientoherramienta->getNombreHerramienta());
	    $seguimiento->setEliminado(1);
        $seguimiento->setEstadoId($estadobodega->getIdEstado());
        $seguimiento->setFecha(new \DateTime());
		$entityManager->persist($seguimiento);
     	$entityManager->flush();
       	return $this->redirectToRoute('detalle_proyecto_herramientas', array('id' => $id));
     }
     //fin asig seguimiento

     /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/editar/herramienta/disponible/{idh}/{id}", name="editar_herramienta_disponible")
     *@Method({"GET","POST"})
     */
     public function EditarHerramientaDisponible($idh, $id)
     {
   	    $entityManager = $this->getDoctrine()->getManager();
  	    $herramientas = $entityManager->getRepository(THerramienta::class)->find($idh);
   	    if(!$herramientas)
   	    {
   	    	throw $this->createNotFoundException("Error Processing Request", $idh);     	    	
   	    }
   	    $herramientas->setOcupado(0);
   	    $entityManager->flush();
   	    $entityManager = $this->getDoctrine()->getManager();
 	    $herramientasproyctoseguimiento = $entityManager->getRepository(TSeguimientoProyectoHerramientas::class)->findOneBy(
    	array(
			'proyectoid' => $id,
			'herramientaid' => $idh,
			'eliminado' => 1,
		));
   	    $herramientasproyctoseguimiento->setEliminado(0);
   	    $entityManager->flush();
   		return $this->redirectToRoute('eliminar_herramienta_detalle', array('idh' => $idh, 'id' => $id));
     }
 
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/eliminar/herramienta/detalle/{idh}/{id}", name="eliminar_herramienta_detalle")
     *@Method({"GET","POST"})
     */
     public function EliminarHerramientaDetalle($idh, $id)
     {
     	$entityManager = $this->getDoctrine()->getManager();
     	$eliminarherramienta = $entityManager->getRepository(TDetalleProyectoHerramientas::class)->findBy(
		array(
		    'proyecto_id' => $id,
			'herramienta_id' => $idh
		));
            foreach ($eliminarherramienta as $eliminarherramientas) {
		    $entityManager->remove($eliminarherramientas);
		}
		$entityManager->flush();
       	return $this->redirectToRoute('detalle_proyecto_herramientas', array('id' => $id));
     }
}
