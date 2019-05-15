<?php

namespace App\Controller;
use App\Entity\THerramienta;
use App\Entity\TMarcab;
use App\Entity\TEstadoBodega;
use App\Entity\TProyecto;
use App\Entity\TTipoBodega;
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
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class HerramientaController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/herramientas", name="lista_herramientas")
     */
    public function ListHerramientas()
    {
       $herramientas = $this->getDoctrine()->getRepository(THerramienta::class)->findBy(
         array('eliminado' => 0),
         array('id' => 'DESC')
     );
       $marcas = $this->getDoctrine()->getRepository(TMarcab::class)->findAll();
       return $this->render('herramienta/herramientas.html.twig', array('herramientas' => $herramientas, 'marcas' => $marcas));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/herramienta/new", name="nueva_herramienta")
    *@Method({"GET","POST"})
    */
    public function NewHerramienta(Request $request)
    {
      $herramientas = new THerramienta();
      $form = $this->createFormBuilder($herramientas)
        ->add('codigo', TextType::class, array('label' => 'Código: '), array('attr' => array('class' => 'form-control')))
      	->add('marcaid', EntityType::class, array(
                'class' => TMarcab::class,
                'choice_label' => 'nombremarca',
                'label' => 'Marca:'))
      	->add('estadoid', EntityType::class, array(
                'class' => TEstadoBodega::class,
                'choice_label' => 'nombreestado',
                'label' => 'Estado:'))
        ->add('nombreherramienta', TextType::class, array('label' => 'Nombre: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('descripcionherramienta', TextType::class, array('label' => 'Descripción: '), array('required' => false, 'attr' => array('class' => 'form-control')))   
		->add('tipoid', EntityType::class, array(
                'class' => TTipoBodega::class,
                'choice_label' => 'nombretipo',
                'label' => 'Seleccione el tipo:'))
        ->add('save', SubmitType::class, array('label' => 'INGRESAR', 'attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() )
            {
            //validaciones
            $errores =0 ;
            $herramientaunica = $this->getDoctrine()->getRepository(THerramienta::class)->findOneBy(
                array(
                'codigo' => $herramientas->getCodigo()
                ));
            if($herramientaunica)
                {
                    $errores = $errores+1;
                    $this->addFlash(
                    'error_repetido',
                    'La  herramienta con este código ya ha sido registrado');  
                }      
        if($errores == 0 && $form->isValid())         
        {
            $herramientas = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($herramientas);
            $entityManager->flush();
            $this->addFlash(
            'notice',
            'Los datos han sido almacenados con éxito!'
            );
            return $this->redirectToRoute('lista_herramientas');
        }
    }
        return $this->render('herramienta/nueva_herramienta.html.twig', array('form' => $form->createView()));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/herramienta/edit/{id}", name="editar_herramienta")
    *@Method({"GET","POST"})
    */
    public function EditHerramienta(Request $request, $id)
    {
      $herramientas = new THerramienta();
      $herramientas = $this->getDoctrine()->getRepository(THerramienta::class)->find($id);
      $form = $this->createFormBuilder($herramientas)
        ->add('marcaid', EntityType::class, array(
                'class' => TMarcab::class,
                'choice_label' => 'nombremarca',
                'label' => 'Marca:'))
        ->add('nombreherramienta', TextType::class, array('label' => 'Nombre: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('descripcionherramienta', TextType::class, array('label' => 'Descripción: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('tipoid', EntityType::class, array(
                'class' => TTipoBodega::class,
                'choice_label' => 'nombretipo',
                'label' => 'Seleccione el tipo:'))
        ->add('save', SubmitType::class, array('label' => 'MODIFICAR', 'attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $herramientas = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($herramientas);
            $entityManager->flush();
            $this->addFlash(
            'notice',
            'Tus cambios se han guardado con éxito!'
            );
            return $this->redirectToRoute('lista_herramientas');
        }
        return $this->render('herramienta/editar_herramienta.html.twig', array('form' => $form->createView(), 'herramientas'=> $herramientas));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/herramienta/show/{id}", name="mostrar_herramiienta")
    *@Method({"GET","POST"})
    */
    public function ShowHerramienta(Request $request, $id)
	{
    	$herramientas = $this->getDoctrine()->getRepository(THerramienta::class)->find($id);
    	$marcas = $this->getDoctrine()->getRepository(TMarcab::class)->find($herramientas->getMarcaId());
        $estados = $this->getDoctrine()->getRepository(TEstadoBodega::class)->find($herramientas->getEstadoId());
        $estadosherramienta = $this->getDoctrine()->getRepository(TEstadoBodega::class)->findAll();
        $proyectos = $this->getDoctrine()->getRepository(TProyecto::class)->findAll();
        $seguimiento = $this->getDoctrine()->getRepository(TSeguimientoProyectoHerramientas::class)->findBy(
        array(
            'herramientaid' => $id
        ));

        /* modificar estado herramienta*/
        $herramientas = new THerramienta();
        $herramientas = $this->getDoctrine()->getRepository(THerramienta::class)->find($id);
          $form = $this->createFormBuilder($herramientas)
            
            ->add('estadoid', EntityType::class, array(
                    'class' => TEstadoBodega::class,
                    'choice_label' => 'nombreestado',
                    'label' => 'Estado:'))
            ->add('save', SubmitType::class, array('label' => 'MODIFICAR', 'attr' => array('class' => 'btn btn-success mt-3')))
            ->getForm();
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid())
            {
                $herramientas = $form->getData();
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($herramientas);
                $entityManager->flush();
                $this->addFlash(
                'notice',
                'Tus cambios se han guardado con éxito!'
                );
                return $this->redirectToRoute('asignar_herramienta_seguimiento', array('id' => $id));
            }
        /* fin S.H.*/

        return $this->render('herramienta/mostrar_herramienta.html.twig', array('herramientas' => $herramientas,'marcas' => $marcas,'estados' => $estados, 'seguimiento' => $seguimiento, 'estadosherramienta'=> $estadosherramienta, 'proyectos'=> $proyectos, 'form' => $form->createView())); 
    }

    //Asignar a seguimiento
     /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/asignar/seguimiento/{id}", name="asignar_herramienta_seguimiento")
     *@Method({"GET","POST"})
     */
     public function AsignarHerramientasSeguimiento($id)
     {
        $entityManager = $this->getDoctrine()->getManager();
        $seguimientoherramienta = $entityManager->getRepository(THerramienta::class)->find($id);
        $estadobodega = $entityManager->getRepository(TEstadoBodega::class)->find($seguimientoherramienta->getEstadoId());
        $seguimiento = new TSeguimientoProyectoHerramientas();
        $seguimiento->setProyectoId(-1);
        $seguimiento->setHerramientaId($id);
        $seguimiento->setCodigoHerramienta($seguimientoherramienta->getCodigo());
        $seguimiento->setHerramientaNombre($seguimientoherramienta->getNombreHerramienta());
        $seguimiento->setEliminado(1);
        $seguimiento->setEstadoId($estadobodega->getIdEstado());
        $seguimiento->setFecha(new \DateTime());
        $entityManager->persist($seguimiento);
        $entityManager->flush();
        return $this->redirectToRoute('mostrar_herramiienta', array('id' => $id));
     }
     //fin asig seguimiento

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/herramienta/delete/{id}", name="eliminar_herramienta")
    */
    public function DeleteHerramienta($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $herramienta = $entityManager->getRepository(THerramienta::class)->find($id);
        $herramienta->setEliminado(1);
        $entityManager->flush();
        $this->addFlash(
        'notice',
        'La herramienta ha sido eliminada!');
        return $this->redirectToRoute('lista_herramientas');
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/reporte/herramientas/{id}", name="reporte_herramientas")
    */
    public function ReporteHerramientasEstado($id)
    {
        $entityManager = $this->getDoctrine()->getManager();     
        $estado = $this->getDoctrine()->getRepository(TEstadoBodega::class)->find($id);
        $estados = $this->getDoctrine()->getRepository(TEstadoBodega::class)->findAll();
        $marcas = $this->getDoctrine()->getRepository(TMarcab::class)->findAll();
        $herramientas = $this->getDoctrine()->getRepository(THerramienta::class)->findBy(
        array(
            'estado_id' => $id,
            'eliminado' => 0,
        ));
        return $this->render('reportes/reporte_herramientas.html.twig', array('marcas'=> $marcas,'herramientas'=> $herramientas, 'estados'=> $estados, 'estado' => $estado));
    }
}
