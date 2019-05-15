<?php

namespace App\Controller;

use App\Entity\TEstadoBodega;

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

class EstadoBodegaController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/estado/bodega", name="estado_bodega")
    */
    public function ListEstadoBodega()
    {
        $estados = $this->getDoctrine()->getRepository(TEstadoBodega::class)->findBy(
         array('eliminado' => 0),
         array('id_estado' => 'DESC')
     );
      	 return $this->render('estado_bodega/estados.html.twig', array('estados' => $estados));
    }

    /**
    * @IsGranted("ROLE_ADMIN")
    *@Route("/estado/bodega/new", name="nuevo_estado_bodega")
    *@Method({"GET","POST"})
    */
 	 public function NewEstadoBodega(Request $request)
    {
    	$estados = new TEstadoBodega();
    	$form = $this->createFormBuilder($estados)
        ->add('nombreestado', TextType::class, array('label' => 'Nombre: '), array('attr' => array('class' => 'form-control')))
        ->add('descripcionestado', TextType::class, array('label' => 'Descripción: '), array('required' => false, 'attr' => array('class' => 'form-control')))
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
            return $this->redirectToRoute('estado_bodega');
        }
        return $this->render('estado_bodega/nuevo_estado.html.twig', array('form' => $form->createView()));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/estado/bodega/edit/{id}", name="editar_estado_bodega")
    *@Method({"GET","POST"})
    */
 	 public function EditEstadoBodega(Request $request, $id)
    {
    	$estados = new TEstadoBodega();
      	$estados = $this->getDoctrine()->getRepository(TEstadoBodega::class)->find($id);
    	$form = $this->createFormBuilder($estados)
        ->add('nombreestado', TextType::class, array('label' => 'Nombre: '), array('attr' => array('class' => 'form-control')))
        ->add('descripcionestado', TextType::class, array('label' => 'Descripcion: '), array('required' => false, 'attr' => array('class' => 'form-control')))
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
            return $this->redirectToRoute('estado_bodega');
        }
        return $this->render('estado_bodega/editar_estado.html.twig', array('form' => $form->createView()));
    }

    /**
    * @IsGranted("ROLE_ADMIN")
    *@Route("/estadobodega/show/{id}", name="mostrar_estadobodega")
    */
    public function ShowEstadoBodega($id)
    {
       $estadobodega = $this->getDoctrine()->getRepository(TEstadoBodega::class)->find($id);
       return $this->render('estado_bodega/mostrar_estado.html.twig', array('estadobodega' => $estadobodega));        
    }

    /**
    * @IsGranted("ROLE_ADMIN")
    *@Route("/estadobodega/delete/{id}", name="eliminar_estadobodega")
    */
     public function DeleteEstadoBodega($id)
    {
        //$clientes = $this->getDoctrine()->getRepository(TCliente::class)->findOneBy(
        //array(
          //  'id_cliente' => $id
        //));
        $entityManager = $this->getDoctrine()->getManager();
        $estadobodega = $entityManager->getRepository(TEstadoBodega::class)->find($id);
        $estadobodega->setEliminado(1);
        $entityManager->flush();
        $this->addFlash(
        'notice',
        '!El estado ha sido eliminado!');
        return $this->redirectToRoute('estado_bodega');
    }
}
