<?php

namespace App\Controller;

use App\Entity\TEstadoProyecto;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class EstadoProyectoController extends AbstractController
{
   /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/estado/proyecto", name="estado_proyecto")
    */
    public function ListEstadoProyecto()
    {
        $estados = $this->getDoctrine()->getRepository(TEstadoProyecto::class)->findBy(
             array('eliminado' => 0),
             array('id_estado_proyecto' => 'DESC')
         );
      	 return $this->render('estado_proyecto/estados_proyecto.html.twig', array('estados' => $estados));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/estado/proyecto/new", name="nuevo_estado_proyecto")
    *@Method({"GET","POST"})
    */
 	 public function NewEstadoProyecto(Request $request)
    {
    	$estados = new TEstadoProyecto();
    	$form = $this->createFormBuilder($estados)
        ->add('nombreestadoproyecto', TextType::class, array('label' => 'Nombre del nuevo estado: '), array('attr' => array('class' => 'form-control')))
        ->add('descripcionestadoproyecto', TextType::class, array('label' => 'Descripción: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('save', SubmitType::class, array('label' => 'INGRESAR', 'attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $estados = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($estados);
            $entityManager->flush();
            $this->addFlash(
            'notice',
            'Los datos han sido almacenados con éxito!'
            );
            return $this->redirectToRoute('estado_proyecto');
        }
        return $this->render('estado_proyecto/nuevo_estado_proyecto.html.twig', array('form' => $form->createView()));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/estado/proyecto/edit/{id}", name="editar_estado_proyecto")
    *@Method({"GET","POST"})
    */
 	 public function EditEstadoProyecto(Request $request, $id)
    {
    	$estados = new TEstadoProyecto();
      	$estados = $this->getDoctrine()->getRepository(TEstadoProyecto::class)->find($id);
    	$form = $this->createFormBuilder($estados)
        ->add('nombreestadoproyecto', TextType::class, array('label' => 'Nombre: '), array('attr' => array('class' => 'form-control')))
        ->add('descripcionestadoproyecto', TextType::class, array('label' => 'Descripción: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('save', SubmitType::class, array('label' => 'MODIFICAR', 'attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $estados = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($estados);
            $entityManager->flush();
            $this->addFlash(
            'notice',
            'Tus cambios se han guardado con éxito!'
            );
            return $this->redirectToRoute('estado_proyecto');
        }
        return $this->render('estado_proyecto/editar_estado_proyecto.html.twig', array('form' => $form->createView()));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/estado/proyecto/delete/{id}", name="eliminar_estado_proyecto")
    */
    public function DeleteEstadoProyecto($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $estado_proyecto = $entityManager->getRepository(TEstadoProyecto::class)->find($id);
        $estado_proyecto->setEliminado(1);
        $entityManager->flush();
        $this->addFlash(
        'notice',
        'El estado ha sido eliminado!');
        return $this->redirectToRoute('estado_proyecto');
    }
}
