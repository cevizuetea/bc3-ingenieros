<?php

namespace App\Controller;

use App\Entity\TCliente;

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

class ClienteController extends AbstractController
{
   /**
   * @IsGranted("ROLE_ADMIN")
     * @Route("/clientes", name="lista_clientes")
     * @Method({"GET"})
     */
    public function ListClientes()
    {
         $clientes = $this->getDoctrine()->getRepository(TCliente::class)->findBy(
         array('eliminado' => 0),
         array('id_cliente' => 'DESC'));
      	 return $this->render('cliente/clientes.html.twig', array('clientes' => $clientes));
    }

    /**
    *@Route("/cliente/new", name="nuevo_cliente")
    *@Method({"GET","POST"})
    */
 	public function NewCliente(Request $request)
    {
    	$cliente = new TCliente();

    	$form = $this->createFormBuilder($cliente)
        ->add('nombrecliente', TextType::class, array('label' => 'Nombre del cliente:'), array('attr' => array('class' => 'form-control ')))
        ->add('direccion', TextareaType::class, array('label' => 'Dirección: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('telefono', IntegerType::class, array('label' => 'Teléfono:  '), array('attr' => array('class' => 'form-control')))
        ->add('save', SubmitType::class, array('label' => 'INGRESAR', 'attr' => array('class' => 'btn btn-success mt-3 ')))
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $marcas = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cliente);
            $entityManager->flush();
            $this->addFlash(
            'notice',
            'Los datos han sido almacenados con éxito!'
            );
            return $this->redirectToRoute('lista_clientes');
        }
        return $this->render('cliente/nuevo_cliente.html.twig', array('form' => $form->createView()));
    }

    /**
    *@Route("/cliente/edit/{id}", name="editar_cliente")
    *@Method({"GET","POST"})
    */
    public function EditCliente(Request $request,  $id)
    {
    	$clientes = new TCliente();
    	$clientes = $this->getDoctrine()->getRepository(TCliente::class)->find($id);

    	$form = $this->createFormBuilder($clientes)
        ->add('nombrecliente', TextType::class, array('label' => 'Nombre del cliente:'), array('attr' => array('class' => 'form-control ')))
        ->add('direccion', TextareaType::class, array('label' => 'Dirección: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('telefono', IntegerType::class, array('label' => 'Teléfono:  '), array('attr' => array('class' => 'form-control')))
        ->add('save', SubmitType::class, array('label' => 'MODIFICAR', 'attr' => array('class' => 'btn btn-success mt-3 ')))
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $clientes = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($clientes);
            $entityManager->flush();
            $this->addFlash(
            'notice',
            'Tus cambios se han guardado con éxito!');
            return $this->redirectToRoute('lista_clientes');
        }
        return $this->render('cliente/editar_cliente.html.twig', array('form' => $form->createView()));
    }

	/**
    *@Route("/cliente/show/{id}", name="mostrar_cliente")
    */
    public function ShowCliente($id)
    {
           $clientes = $this->getDoctrine()->getRepository(TCliente::class)->find($id);
           return $this->render('cliente/mostrar_cliente.html.twig', array('clientes' => $clientes));        
    }

    /**
    *@Route("/cliente/delete/{id}", name="eliminar_cliente")
    */
    public function DeleteCliente($id)
    {
        //$clientes = $this->getDoctrine()->getRepository(TCliente::class)->findOneBy(
        //array(
          //  'id_cliente' => $id
        //));

        $entityManager = $this->getDoctrine()->getManager();
        $clientes = $entityManager->getRepository(TCliente::class)->find($id);
        $clientes->setEliminado(1);
        $entityManager->flush();
        $this->addFlash(
        'notice',
        '!El cliente ha sido eliminado!');
        return $this->redirectToRoute('lista_clientes');
    }
}
