<?php

namespace App\Controller;

use App\Entity\TMarcab;
use App\Entity\TMaterial;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class MaterialController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/materiales", name="lista_materiales")
     */
    public function ListMateriales()
    {
       $materiales = $this->getDoctrine()->getRepository(TMaterial::class)->findBy(
         array('eliminado' => 0),
         array('id' => 'DESC')
       );
       $marcas = $this->getDoctrine()->getRepository(TMarcab::class)->findAll();
       return $this->render('material/materiales.html.twig', array('materiales' => $materiales, 'marcas' => $marcas));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/material/new", name="nuevo_material")
    *@Method({"GET","POST"})
    */
    public function NewMaterial(Request $request)
    {
      $materiales = new TMaterial();
      $form = $this->createFormBuilder($materiales)
        ->add('codigomaterial', TextType::class, array('label' => 'Código: '), array('attr' => array('class' => 'form-control')))
      	->add('marcaid', EntityType::class, array(
                'class' => TMarcab::class,
                'choice_label' => 'nombremarca'))
        ->add('nombrematerial', TextType::class, array('label' => 'Nombre: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('descripcionmaterial', TextType::class, array('label' => 'Descripción: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('cantidad', IntegerType::class, array('label' => 'Cantidad: '), array('required' => false, 'attr' => array('class' => 'form-control')))    
        ->add('preciounitario', TextType::class, array('label' => 'Precio Unitario: $'), array('required' => false, 'attr' => array('class' => 'form-control')))    
		
        ->add('save', SubmitType::class, array('label' => 'INGRESAR', 'attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() )
        {
            $materiales = $form->getData();
            //validaciones
            $errores =0 ;
            $materialunico = $this->getDoctrine()->getRepository(TMaterial::class)->findOneBy(
                array(
                'codigo_material' => $materiales->getCodigoMaterial()
                ));
            if($materialunico)
                {
                    $errores = $errores+1;
                    $this->addFlash(
                    'error_repetido',
                    'El material con este código ya ha sido registrado');  
                }
            if($materiales->getCantidad() < 0)
                {
                    $errores = $errores+1;
                    $this->addFlash(
                    'error_cantidad',
                    '* No se permiten valores negativos');  
                }
            if($materiales->getPrecioUnitario() < 0)
                {
                    $errores = $errores+1;
                    $this->addFlash(
                    'error_precio',
                    '* No se permiten valores negativos');  
                }
            if($errores == 0 && $form->isValid())
            {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($materiales);
                $entityManager->flush();
                $this->addFlash(
                'notice',
                'Tus cambios se han guardado con éxito!');
                $materiales->setPrecioTotal($materiales->getCantidad() * $materiales->getPrecioUnitario());
                $entityManager->flush();
                return $this->redirectToRoute('lista_materiales');
            }
        }
        return $this->render('material/nuevo_material.html.twig', array('form' => $form->createView()));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/material/edit/{id}", name="editar_material")
    *@Method({"GET","POST"})
    */
    public function EditMaterial(Request $request, $id)
    {
      $materiales = new TMaterial();
      $entityManager = $this->getDoctrine()->getManager();
      $materiales = $entityManager->getRepository(TMaterial::class)->find($id);
      $form = $this->createFormBuilder($materiales)
        ->add('marcaid', EntityType::class, array(
                'class' => TMarcab::class,
                'choice_label' => 'nombremarca',
                'label' => 'Marca: '))
        ->add('nombrematerial', TextType::class, array('label' => 'Nombre: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('descripcionmaterial', TextType::class, array('label' => 'Descripción: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('cantidad', IntegerType::class, array('label' => 'Cantidad: '), array('required' => false, 'attr' => array('class' => 'form-control')))    
        ->add('preciounitario', TextType::class, array('label' => 'Precio Unitario: $'), array('required' => false, 'attr' => array('class' => 'form-control')))    
        
        ->add('save', SubmitType::class, array('label' => 'MODIFICAR', 'attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() )
        {
            $materiales = $form->getData();
            $errores = 0;
            if($materiales->getCantidad() < 0)
                {
                    $errores = $errores+1;
                    $this->addFlash(
                    'error_cantidad',
                    '* No se permiten valores negativos');  
                }
            if($materiales->getPrecioUnitario() < 0)
                {
                    $errores = $errores+1;
                    $this->addFlash(
                    'error_precio',
                    '* No se permiten valores negativos');  
                }
            if($errores == 0 && $form->isValid())
            {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($materiales);
                $entityManager->flush();
                $materiales->setPrecioTotal($materiales->getCantidad() * $materiales->getPrecioUnitario());
                $entityManager->flush();
                $this->addFlash(
                'notice',
                'Tus cambios se han guardado con éxito!');
                return $this->redirectToRoute('lista_materiales');
            }
        }
        return $this->render('material/editar_material.html.twig', array('form' => $form->createView(), 'materiales'=>$materiales));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/material/show/{id}", name="mostrar_material")
    *@Method({"GET","POST"})
    */
    public function ShowMaterial($id)
	{

	$materiales = $this->getDoctrine()->getRepository(TMaterial::class)->find($id);
	$marcas = $this->getDoctrine()->getRepository(TMarcab::class)->find($materiales->getMarcaid());
       return $this->render('material/mostrar_material.html.twig', array('materiales' => $materiales,'marcas' => $marcas)); 
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/material/delete/{id}", name="eliminar_material")
    */
  public function DeleteMaterial($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $material = $entityManager->getRepository(TMaterial::class)->find($id);
        if($material->getCantidad() > 0)
        {
            $this->addFlash(
            'error',
            'El material no se pudo eliminar, aun existe en stock!');
        }
        else
        {
            $material->setEliminado(1);
            $entityManager->flush();
            $this->addFlash(
            'notice',
            'El material ha sido eliminado!');
        }
        
        return $this->redirectToRoute('lista_materiales');
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/reporte/materiales", name="reporte_materiales")
    */
    public function ReporteMaterialesStock()
    {
        $entityManager = $this->getDoctrine()->getManager();    
        $materiales = $this->getDoctrine()->getRepository(TMaterial::class)->findBy(
        array(
            'cantidad' => 0,
            'eliminado' => 0,
        ));
        return $this->render('reportes/reporte_materiales.html.twig', array('materiales'=> $materiales ));
    }
}
 