<?php

namespace App\Controller;

use App\Entity\TCargo;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class CargoController extends AbstractController
{
    /**
    * @IsGranted("ROLE_ADMIN")
     * @Route("/cargos", name="cargos_emplados")
     * @Method({"GET"})
     */
    public function ListCargos()
    {
         $cargos = $this->getDoctrine()->getRepository(TCargo::class)->findBy(
         array('eliminado' => 0),
         array('id_cargo' => 'DESC')
     );
         return $this->render('cargo/cargos.html.twig', array('cargos' => $cargos));
    }



    /**
    * @IsGranted("ROLE_ADMIN")
    *@Route("/cargo/new", name="nuevo_cargo")
    *@Method({"GET","POST"})
    */
    public function NewCargo(Request $request)
    {
      $cargos = new TCargo();

      $form = $this->createFormBuilder($cargos)
        ->add('nombrecargo', TextType::class, array('label' => 'Nombre: '), array('attr' => array('class' => 'form-control')))
        ->add('descripcion', TextType::class, array('label' => 'Descripción: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('rol', ChoiceType::class, array(
              'choices'  => array(
                  'ROLE_ADMIN' => 'ROLE_ADMIN',
                  'ROLE_USER' => 'ROLE_USER',
                  'ROLE_SIN_ACCESO' => 'ROLE_SIN_ACCESO',
              )))
        ->add('save', SubmitType::class, array('label' => 'INGRESAR', 'attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $cargos = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cargos);
            $entityManager->flush();
            $this->addFlash(
            'notice',
            'Los datos han sido almacenados con éxito!'
            );
            return $this->redirectToRoute('cargos_emplados');
        }
        return $this->render('cargo/nuevo_cargo.html.twig', array('form' => $form->createView()));
    }


    /**
    * @IsGranted("ROLE_ADMIN")
    *@Route("/cargo/edit/{id}", name="editar_cargo")
    *@Method({"GET","POST"})
    */
    public function EditCargo(Request $request, $id)
    {
      $cargo = new TCargo();
      $cargo = $this->getDoctrine()->getRepository(TCargo::class)->find($id);

      $form = $this->createFormBuilder($cargo)
        ->add('nombrecargo', TextType::class, array('label' => 'Nombre: '), array('attr' => array('class' => 'form-control')))
        ->add('descripcion', TextType::class, array('label' => 'Descripción: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('rol', ChoiceType::class, array(
              'choices'  => array(
                  'ROLE_ADMIN' => 'ROLE_ADMIN',
                  'ROLE_USER' => 'ROLE_USER',
                  'ROLE_SIN_ACCESO' => 'ROLE_SIN_ACCESO',
              )))
        ->add('save', SubmitType::class, array('label' => 'MODIFICAR','attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) 
      {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();
        $this->addFlash(
            'notice',
            'Tus cambios se han guardado con éxito!'
            );
        return $this->redirectToRoute('cargos_emplados');
      }
      return $this->render('cargo/editar_cargo.html.twig', array(
        'form' => $form->createView()
      ));
    }

    /**
    *@Route("/cargo/save")
    */

  	public function save()
  	  {
  	    $entityManager = $this->getDoctrine()->getManager();
       $cargo = new TCargo();
        $cargo->setIdCargo(8);
        $cargo->setNombreCargo('HSHLLLSH');
       $cargo->setDescripcion('descripcion de la  otra cargo');

	    $entityManager->persist($cargo);
        $entityManager->flush();
    return new Response('Saved new name with id '.$cargo->getIdCargo());

  }

      /**
      * @IsGranted("ROLE_ADMIN")
    *@Route("/cargo/show/{id}", name="mostrar_cargo")
    */

    public function ShowCargo($id)
    {
       $cargos = $this->getDoctrine()->getRepository(TCargo::class)->find($id);
       return $this->render('cargo/mostrar_cargo.html.twig', array('cargos' => $cargos));        
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/cargo/delete/{id}", name="eliminar_cargo")
    */
    public function DeleteCargo($id)
    {
        //$clientes = $this->getDoctrine()->getRepository(TCliente::class)->findOneBy(
        //array(
          //  'id_cliente' => $id
        //));
        $entityManager = $this->getDoctrine()->getManager();
        $cargos = $entityManager->getRepository(TCargo::class)->find($id);
        $cargos->setEliminado(1);
        $entityManager->flush();
        $this->addFlash(
        'notice',
        'El cargo ha sido eliminado!');
        return $this->redirectToRoute('cargos_emplados');
    }
}
