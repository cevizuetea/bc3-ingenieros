<?php

namespace App\Controller;

use App\Entity\TMarcab;

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


class MarcaController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/marcas", name="marcas")
     * @Method({"GET"})
     */
    public function ListMarcas()
    {
         $marcas = $this->getDoctrine()->getRepository(TMarcab::class)->findBy(
         array('eliminado' => 0),
         array('id' => 'DESC')
          );
      	 return $this->render('marca/marca.html.twig', array('marcas' => $marcas));
    }

   	/**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/marca/new", name="nueva_marca")
    *@Method({"GET","POST"})
    */
 	 public function NewMarca(Request $request)
    {
    	$marcas = new TMarcab();
    	$form = $this->createFormBuilder($marcas)
        ->add('nombremarca', TextType::class, array('label' => 'Nombre: '), array('attr' => array('class' => 'form-control')))
        ->add('descripcion', TextType::class, array('label' => 'Descripción: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('save', SubmitType::class, array('label' => 'INGRESAR', 'attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $marcas = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($marcas);
            $entityManager->flush();
            return $this->redirectToRoute('marcas');
        }
        return $this->render('marca/nueva_marca.html.twig', array('form' => $form->createView()));
    }


    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/marca/edit/{id}", name="editar_marca")
    *@Method({"GET","POST"})
    */
    public function EditMarca(Request $request, $id) {
      $marcas = new TMarcab();
      $marcas = $this->getDoctrine()->getRepository(TMarcab::class)->find($id);
      $form = $this->createFormBuilder($marcas)
        ->add('nombremarca', TextType::class, array('label' => 'Nombre: '), array('attr' => array('class' => 'form-control')))
        ->add('descripcion', TextType::class, array('label' => 'Descripción: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('save', SubmitType::class, array('label' => 'MODIFICAR','attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()) 
      {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        return $this->redirectToRoute('marcas');
      }
      return $this->render('marca/editar_marca.html.twig', array(
        'form' => $form->createView()
      ));
    }

  /**
  *@IsGranted("ROLE_ADMIN")
  *@Route("/marca/show/{id}", name="mostrar_marca")
  */
  public function ShowMarca($id)
  {
    $marcas = $this->getDoctrine()->getRepository(TMarcab::class)->find($id);
    return $this->render('marca/mostrar_marca.html.twig', array('marcas' => $marcas));        
  }
    
  /**
  *@IsGranted("ROLE_ADMIN")
  *@Route("/marca/delete/{id}", name="eliminar_marca")
  */
  public function DeleteMarca($id)
  {
    $entityManager = $this->getDoctrine()->getManager();
    $marca = $entityManager->getRepository(TMarcab::class)->find($id);
    $marca->setEliminado(1);
    $entityManager->flush();
    $this->addFlash(
    'notice',
    'La marca ha sido eliminada!');
    return $this->redirectToRoute('marcas');
  }	
}
