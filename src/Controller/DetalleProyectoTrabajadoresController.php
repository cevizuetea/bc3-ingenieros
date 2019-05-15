<?php

namespace App\Controller;

use App\Entity\TDetalleProyectoTrabajadores;
use App\Entity\TProyecto;
use App\Entity\TCliente;
use App\Entity\TEstadoProyecto;
use App\Entity\TTrabajadores;
use App\Entity\THerramienta;
use App\Entity\TSeguimientoProyectoTrabajadores;

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

class DetalleProyectoTrabajadoresController extends AbstractController
{
   /**
     * @Route("/asignar/trabajadores/{id}", name="detalle_proyecto_trabajadores")
     *@Method({"GET","POST"})
     */
    public function AsignarTrabajadores(Request $request, $id)
    {
    $proyectos = $this->getDoctrine()->getRepository(TProyecto::class)->find($id);
    $cliente = $this->getDoctrine()->getRepository(TCliente::class)->find($proyectos->getClienteId());
    $estados = $this->getDoctrine()->getRepository(TEstadoProyecto::class)->find($proyectos->getEstadoId());
    $trabajador = $this->getDoctrine()->getRepository(TTrabajadores::class)->find($proyectos->getTrabajadorId());
 	
 	$trabajadoresasignados = $this->getDoctrine()->getRepository(TDetalleProyectoTrabajadores::class)->findBy(
	array(
		'idproyecto' => $id
	));
	$trabajadoresseguimiento = $this->getDoctrine()->getRepository(TSeguimientoProyectoTrabajadores::class)->findBy(
	array(
		'proyectoid' => $id,
		'eliminado' => 1,
	));
 	$detalle = new TDetalleProyectoTrabajadores($id);
    $form = $this->createFormBuilder($detalle)
    ->add('idproyecto', EntityType::class, array(
                'class' => TProyecto::class,
                'query_builder' => function (EntityRepository $er) use ($id){
                        return $er->createQueryBuilder('p')
                        	->Where('p.id_proyecto = :idd')
                        	->setParameter('idd', $id);                           
                    },
                'choice_label' => 'nombre_proyecto',
            	))
    ->add('trabajadorid', EntityType::class, array(
                'class' => TTrabajadores::class,
                'query_builder' => function (EntityRepository $er){
                        return $er->createQueryBuilder('t')
                        	->Where('t.disponibilidad = 0');                            
                    },
                'choice_label' => 'nombres',
                'label'=> 'Nombre del trabajador:'))
        ->add('save', SubmitType::class, array('label' => 'Asignar', 'attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $detalle = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($detalle);
            $entityManager->flush();
            $trabajadorasignado = $this->getDoctrine()->getRepository(TTrabajadores::class)->find($detalle->getTrabajadorId());
            $idt = $trabajadorasignado->getIdTrabajador();
            $this->addFlash(
            'notice',
            'El trabajador se asignó con éxito!'
            );
       		return $this->redirectToRoute('editar_trabajador_disponibilidad', array('idt' => $idt,'id' => $id));
        }  
       return $this->render('proyecto/asignar_trabajadores.html.twig', array('proyectos' => $proyectos,'cliente' => $cliente, 'estados' => $estados, 'trabajador' => $trabajador, 'trabajadoresasignados' => $trabajadoresasignados, 'trabajadoresseguimiento' => $trabajadoresseguimiento, 'form' => $form->createView())); 
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/editar/trabajador/ocupado/{idt}/{id}", name="editar_trabajador_disponibilidad")
     *@Method({"GET","POST"})
     */
     public function EditarTrabajadorOcupado($idt, $id)
     {
     	$entityManager = $this->getDoctrine()->getManager();
     	$trabajadores = $entityManager->getRepository(TTrabajadores::class)->find($idt);
     	if(!$trabajadores)
     	{
     	  	throw $this->createNotFoundException("Error Processing Request", $idt);     	    	
     	}
     	$trabajadores->setDisponibilidad(1);
     	$entityManager->flush();
       	return $this->redirectToRoute('seguimiento_trbajador', array('idt' => $idt, 'id' => $id));
     }

     //Asignar a seguimiento
     /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/asignar/trabajadores/seguimiento/{idt}/{id}", name="seguimiento_trbajador")
     *@Method({"GET","POST"})
     */
     public function AsignarTrabajadorSeguimiento($idt, $id)
     {
     	$entityManager = $this->getDoctrine()->getManager();
     	$seguimientotrabajador = $entityManager->getRepository(TTrabajadores::class)->find($idt);
	    $seguimiento = new TSeguimientoProyectoTrabajadores();
	    $seguimiento->setProyectoid($id);
	    $seguimiento->setTrabajadorid($idt);
	    $seguimiento->setCedulaTrabajador($seguimientotrabajador->getCi());
	    $seguimiento->setNombresTrabajador($seguimientotrabajador->getNombres());
	    $seguimiento->setApellidosTrabajador($seguimientotrabajador->getApellidos());
	    $seguimiento->setEliminado(1);  
        $seguimiento->setFecha(new \DateTime());
		$entityManager->persist($seguimiento);
     	$entityManager->flush();
       	return $this->redirectToRoute('detalle_proyecto_trabajadores', array('id' => $id));
     }

     /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/editar/trabajador/disponible/{idt}/{id}", name="editar_trabajador_disponible")
     *@Method({"GET","POST"})
     */
     public function EditarTrabajadorDisponible($idt, $id)
     {
     	    $entityManager = $this->getDoctrine()->getManager();
     	    $trabajadores = $entityManager->getRepository(TTrabajadores::class)->find($idt);
     	    if(!$trabajadores)
     	    {
     	    	throw $this->createNotFoundException("Error Processing Request", $it);     	    	
     	    }
     	    $trabajadores->setDisponibilidad(0);
     	    $entityManager->flush();
     	    $entityManager = $this->getDoctrine()->getManager();
     	    $trabajadoresproyectoseguimiento = $entityManager->getRepository(TSeguimientoProyectoTrabajadores::class)->findOneBy(
			array(
				'proyectoid' => $id,
				'trabajadorid' => $idt,
				'eliminado' => 1,
			));
     	    $trabajadoresproyectoseguimiento->setEliminado(0);
     	    $entityManager->flush();
       		return $this->redirectToRoute('eliminar_trabajador_detalle', array('idt' => $idt, 'id' => $id));
     }

     /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/eliminar/trabajador/detalle/{idt}/{id}", name="eliminar_trabajador_detalle")
     *@Method({"GET","POST"})
     */
     public function EliminarTrabajadorDetalle($idt, $id)
     {
     	$entityManager = $this->getDoctrine()->getManager();
     	$eliminartrabajador = $entityManager->getRepository(TDetalleProyectoTrabajadores::class)->findBy(
		array(
			'idproyecto' => $id,
			'trabajador_id' => $idt
    	));
     	    foreach ($eliminartrabajador as $eliminartrabajadores) {
			$entityManager->remove($eliminartrabajadores);
		}
		$entityManager->flush();
       	return $this->redirectToRoute('detalle_proyecto_trabajadores', array('id' => $id));
     }
}
