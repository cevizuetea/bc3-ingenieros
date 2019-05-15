<?php

namespace App\Controller;

use App\Entity\TProveedor;

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

class ProveedorController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/proveedores", name="lista_proveedores")
     */
    public function ListProveedores()
    {
        $proveedores = $this->getDoctrine()->getRepository(TProveedor::class)->findBy(
             array('eliminado' => 0),
             array('id_proveedor' => 'DESC')
         );
      	 return $this->render('proveedor/proveedores.html.twig', array('proveedores' => $proveedores));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/proveedor/new", name="nuevo_proveedor")
    *@Method({"GET","POST"})
    */
 	 public function NewProveedor(Request $request)
    {
    	$proveedor = new TProveedor();
    	$form = $this->createFormBuilder($proveedor)
        ->add('nombreproveedor', TextType::class, array('label' => 'Nombre: '), array('attr' => array('class' => 'form-control')))
        ->add('ruc', TextType::class, array('label' => 'Ruc: '), array('attr' => array('class' => 'form-control')))
        ->add('direccion', TextareaType::class, array('label' => 'Dirección: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('telefono', IntegerType::class, array('label' => 'Teléfono:  '), array('attr' => array('class' => 'form-control')))
        ->add('save', SubmitType::class, array('label' => 'INGRESAR', 'attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted())
        { 
            $errores =0 ;
            if($proveedor->getTelefono() < 0)
                {
                    $errores = $errores+1;
                    $this->addFlash(
                    'error_tel',
                    '* No se permiten valores negativos');  
                }
           if( $errores == 0 && $form->isValid())
                {
                    $proveedor = $form->getData();

                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($proveedor);
                    $entityManager->flush();
                    $this->addFlash(
                    'notice',
                    'Los datos han sido almacenados con éxito!'
                    );
                    return $this->redirectToRoute('lista_proveedores');
                }
        }
        return $this->render('proveedor/nuevo_proveedor.html.twig', array('form' => $form->createView()));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/proveedor/edit/{id}", name="editar_proveedor")
    *@Method({"GET","POST"})
    */
 	 public function EditProveedor(Request $request, $id)
    {
    	$proveedor = new TProveedor();
	    $proveedor = $this->getDoctrine()->getRepository(TProveedor::class)->find($id);
    	$form = $this->createFormBuilder($proveedor)
        ->add('nombreproveedor', TextType::class, array('label' => 'Nombre: '), array('attr' => array('class' => 'form-control')))
        ->add('ruc', TextType::class, array('label' => 'Ruc: '), array('attr' => array('class' => 'form-control')))
        ->add('direccion', TextType::class, array('label' => 'Dirección: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('telefono', IntegerType::class, array('label' => 'Teléfono:  '), array('attr' => array('class' => 'form-control')))
        ->add('save', SubmitType::class, array('label' => 'MODIFICAR', 'attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $proveedor = $form->getData();
            $errores =0 ;
            if($proveedor->getTelefono() < 0)
                {
                    $errores = $errores+1;
                    $this->addFlash(
                    'error_tel',
                    '* No se permiten valores negativos');  
                }
            if( $errores == 0 && $form->isValid())
                {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($proveedor);
                $entityManager->flush();
                $this->addFlash(
                'notice',
                'Tus cambios se han guardado con éxito!');
                return $this->redirectToRoute('lista_proveedores');
                }
        }
        return $this->render('proveedor/editar_proveedor.html.twig', array('form' => $form->createView(), 'proveedor'=>$proveedor));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/proveedor/show/{id}", name="mostrar_proveedor")
    */

	  public function ShowProveedor($id)
	    {
	       $proveedor = $this->getDoctrine()->getRepository(TProveedor::class)->find($id);
	       return $this->render('proveedor/mostrar_proveedor.html.twig', array('proveedor' => $proveedor));        
	   }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/proveedor/delete/{id}", name="eliminar_proveedor")
    */
  public function DeleteProveedor($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $proveedor = $entityManager->getRepository(TProveedor::class)->find($id);
        $proveedor->setEliminado(1);
        $entityManager->flush();
        $this->addFlash(
        'notice',
        '!El proveedor ha sido eliminado!');
        return $this->redirectToRoute('lista_proveedores');
    }
}
