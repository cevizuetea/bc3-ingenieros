<?php

namespace App\Controller;

use App\Entity\TTipoBodega;

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

class TipoBodegaController extends AbstractController
{
    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/tipo/bodega", name="tipos_bodega")
    */   
    public function ListTipoBodega()
    {
         $tipos = $this->getDoctrine()->getRepository(TTipoBodega::class)->findBy(
         array('eliminado' => 0));
      	 return $this->render('tipos_bodega/tipos_bodega.html.twig', array('tipos' => $tipos));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/tipo/bodega/new", name="nuevo_tipo_bodega")
    *@Method({"GET","POST"})
    */
 	 public function NewTipoBodega(Request $request)
    {
    	$tipos = new TTipoBodega();
    	$form = $this->createFormBuilder($tipos)
        ->add('nombretipo', TextType::class, array('label' => 'Nombre: '), array('attr' => array('class' => 'form-control')))
        ->add('descripciontipo', TextType::class, array('label' => 'Descripción: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('save', SubmitType::class, array('label' => 'INGRESAR', 'attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $tipos = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tipos);
            $entityManager->flush();
            $this->addFlash(
            'notice',
            'Los datos han sido almacenados con éxito!'
            );
            return $this->redirectToRoute('tipos_bodega');
        }
        return $this->render('tipos_bodega/nuevo_tipo_bodega.html.twig', array('form' => $form->createView()));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/tipo/bodega/edit/{id}", name="editar_tipo_bodega")
    *@Method({"GET","POST"})
    */
 	 public function EditTipoBodega(Request $request, $id)
    {
    	$tipos = new TTipoBodega();
      	$tipos = $this->getDoctrine()->getRepository(TTipoBodega::class)->find($id);
    	$form = $this->createFormBuilder($tipos)
        ->add('nombretipo', TextType::class, array('label' => 'Nombre: '), array('attr' => array('class' => 'form-control')))
        ->add('descripciontipo', TextType::class, array('label' => 'Descripción: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('save', SubmitType::class, array('label' => 'MODIFICAR', 'attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $tipos = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tipos);
            $entityManager->flush();
            $this->addFlash(
            'notice',
            'Tus cambios se han guardado con éxito!'
            );
            return $this->redirectToRoute('tipos_bodega');
        }
        return $this->render('tipos_bodega/editar_tipo_bodega.html.twig', array('form' => $form->createView()));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/tipobodega/delete/{id}", name="eliminar_tipobodega")
    */
    public function DeleteTipoBodega($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $tipobodega = $entityManager->getRepository(TTipoBodega::class)->find($id);
        $tipobodega->setEliminado(1);
        $entityManager->flush();
        $this->addFlash(
          'notice',
          'El tipo se ha sido eliminada!');
        return $this->redirectToRoute('tipos_bodega');
    }
}
