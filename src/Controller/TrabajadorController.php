<?php

namespace App\Controller;

use App\Entity\TTrabajadores;
use App\Entity\TCargo;
use App\Entity\TSeguimientoProyectoTrabajadores;
use App\Entity\TProyecto;
use Tavo;

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
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class TrabajadorController extends AbstractController
{

	 /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/trabajador/list", name="lista_trajadores")
     *@Method({"GET","POST"})
     */
    public function ListTrabajadores(Request $request)
    {
         $trabajadores = $this->getDoctrine()->getRepository(TTrabajadores::class)->findBy(
           array('eliminado' => 0),
           array('id_trabajador' => 'DESC')
         );
      	 return $this->render('trabajador/trabajadores.html.twig', array('trabajadores' => $trabajadores, ));
    }
   
   ///**
     //* @Route("/trabajador", name="trabajador")
    // */
   //public function index()
   // {
    //    $cargo = new TCargo();   

     //   $empleados = new TTrabajadores();
     //   $empleados->setCi('0987654321');
     //   $empleados->setNombres('aa aa!');
     //   $empleados->setApellidos('aa');
     //   $empleados->setEdad(12);
     //   $empleados->setDireccion('aa aa aa!');
     //   $empleados->setTelefono('0987654321');
     //   $empleados->setFechaIngreso(new \DateTime());
     //   $empleados->setSueldo(23.4);
     //   $empleados->setFechaSalida(new \DateTime());

        // relates this product to the category
     //   $empleados->setCargoId(1);

     //   $entityManager = $this->getDoctrine()->getManager();
     //   $entityManager->persist($empleados);
     //   $entityManager->flush();

     //   return new Response(
     //       'Saved new product with id: '.$cargo->getIdCargo()
     //       .' and new category with id: '.$empleados->getIdTrabajador()
     //   );
    //}

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/trabajador/new", name="nuevo_trabajador")
    *@Method({"GET","POST"})
    */
   public function NewTrabajador(Request $request)
    {
      $trabajador = new TTrabajadores();

      $form = $this->createFormBuilder($trabajador)
      	->add('cargoid', EntityType::class, array(
                'class' => TCargo::class,
                'choice_label' => 'nombrecargo', 
                'label' => 'Seleccione un cargo: '))
        ->add('ci', TextType::class, array('label' => 'Cédula: '), array('attr' => array('class' => 'form-control')))
        ->add('nombres', TextType::class, array('label' => 'Nombres: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('apellidos', TextType::class, array('label' => 'Apellidos: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('edad', IntegerType::class, array('label' => 'Edad: '), array('required' => false, 'attr' => array('class' => 'form-control')))    
        ->add('direccion', TextType::class, array('label' => 'Dirección: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('telefono', IntegerType::class, array('label' => 'Teléfono: '), array('required' => false, 'attr' => array('class' => 'form-control')))
		
        ->add('fechaingreso', DateType::class, [
            'widget' => 'single_text',
            // this is actually the default format for single_text
            'format' => 'yyyy-MM-dd',
            'label' => 'Fecha de ingreso: '
        ])
		->add('sueldo', TextType::class, array('label' => 'Sueldo $: '), array('required' => false, 'attr' => array('class' => 'form-control')))
		->add('fechasalida', DateType::class, [
            'widget' => 'single_text',
            // this is actually the default format for single_text
            'format' => 'yyyy-MM-dd',
            'label' => 'Fecha de salida: '
        ])
        ->add('save', SubmitType::class, array('label' => 'INGRESAR', 'attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted())
        {
            $trabajador = $form->getData();
            //Cargar el autoload de composer
            //require 'vendor/autoload.php';
            // Crear nuevo objeto            
            //$validador = new Tavo\ValidadorEc; validar el numero de cedula
            // validar CI
            //if ($validador->validarCedula($trabajador->getCi())) valid el nuemro de cedula
            $errores =0 ;
            $trabajadorunico = $this->getDoctrine()->getRepository(TTrabajadores::class)->findOneBy(
                array(
                'ci' => $trabajador->getCi()
                ));
            if($trabajadorunico)
                {
                    $errores = $errores+1;
                    $this->addFlash(
                    'error_repetido',
                    ' Este usuario ya ha sido registrado');  
                }
            if($trabajador->getCi() < 0)
                {
                    $errores = $errores+1;
                    $this->addFlash(
                    'error_ci',
                    '* No se permiten valores negativos');  
                }
            if($trabajador->getEdad() > 18 && $trabajador->getEdad() < 70)
            {               
            } else {
                $errores = $errores+1;
                $this->addFlash(
                'error_edad',
                '* El trabajador no cumple con la edad requerida');       
            }
             if($trabajador->getFechaIngreso() > $trabajador->getFechaSalida())
                {   
                    $errores = $errores+1;
                    $this->addFlash(
                    'error_fecha',
                    '* La fecha de salida debe ser mayor a la de ingreso');                            
                }                
                if($trabajador->getSueldo() < 0)
                {
                    $errores = $errores+1;
                    $this->addFlash(
                    'error_sueldo',
                    '* No se permiten valores negativos');  
                }
                if($trabajador->getTelefono() < 0)
                {
                    $errores = $errores+1;
                    $this->addFlash(
                    'error_tel',
                    '* No se permiten valores negativos');  
                }
            if($errores == 0)
            {
                if($form->isValid())
                 {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($trabajador);
                    $entityManager->flush();
                    $id = $trabajador->getIdTrabajador();
                    /*Crea un usuario en la table user*/  
                    }
                    $this->addFlash(
                    'notice',
                    'Los datos han sido almacenados con éxito!');
                     return $this->redirectToRoute('usuario', array('id' => $id));
            }           
        }
        return $this->render('trabajador/nuevo_trabajador.html.twig', array('form' => $form->createView()));
    }

    /**
    * @IsGranted("ROLE_ADMIN")
    *@Route("/trabajador/edit/{id}", name="editar_trabajador")
    *@Method({"GET","POST"})
    */
    public function EditTrabajador(Request $request, $id)
    {
      $trabajador = new TTrabajadores();
      $trabajador = $this->getDoctrine()->getRepository(TTrabajadores::class)->find($id);
      $form = $this->createFormBuilder($trabajador)
      	->add('cargoid', EntityType::class, array(
                'class' => TCargo::class,
                'choice_label' => 'nombrecargo', 
                'label' => 'Seleccione un cargo: '))
        ->add('nombres', TextType::class, array('label' => 'Nombres: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('apellidos', TextType::class, array('label' => 'Apellidos: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('edad', IntegerType::class, array('label' => 'Edad: '), array('required' => false, 'attr' => array('class' => 'form-control')))    
        ->add('direccion', TextType::class, array('label' => 'Dirección: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('telefono', TextType::class, array('label' => 'Teléfono: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('fechaingreso', DateType::class, [
            'widget' => 'single_text',
            // this is actually the default format for single_text
            'format' => 'yyyy-MM-dd',
            'label' => 'Fecha de ingreso: '
        ])
        ->add('sueldo', TextType::class, array('label' => 'Sueldo: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('fechasalida', DateType::class, [
            'widget' => 'single_text',
            // this is actually the default format for single_text
            'format' => 'yyyy-MM-dd',
            'label' => 'Fecha de salida: '
        ])
        ->add('save', SubmitType::class, array('label' => 'MODIFICAR', 'attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() )
        {
            $trabajador = $form->getData();
            $errores =0 ;       
            if($trabajador->getEdad() > 18 && $trabajador->getEdad() < 70)
            {               
            } else {
                $errores = $errores+1;
                $this->addFlash(
                'error_edad',
                '* El trabajador no cumple con la edad requerida');       
            }
             if($trabajador->getFechaIngreso() > $trabajador->getFechaSalida())
                {   
                    $errores = $errores+1;
                    $this->addFlash(
                    'error_fecha',
                    '* La fecha de salida debe ser mayor a la de ingreso');                            
                }                 
                if($trabajador->getSueldo() < 0)
                {
                    $errores = $errores+1;
                    $this->addFlash(
                    'error_sueldo',
                    '* No se permiten valores negativos');  
                }
                if($trabajador->getTelefono() < 0)
                {
                    $errores = $errores+1;
                    $this->addFlash(
                    'error_tel',
                    '* No se permiten valores negativos');  
                }
            if($errores == 0)
            {
                if($form->isValid())
                 {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($trabajador);
                    $entityManager->flush();
                    $id = $trabajador->getIdTrabajador();
                    /*Crea un usuario en la table user*/  
                    }
                    $this->addFlash(
                    'notice',
                    'Tus cambios se han guardado con éxito!');
                    return $this->redirectToRoute('lista_trajadores');
            }            
        }
        return $this->render('trabajador/editar_trabajador.html.twig', array('form' => $form->createView(), 'trabajador'=>$trabajador));
    }

 	/**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/trabajador/show/{id}", name="mostrar_trabajador")
    *@Method({"GET","POST"})
    */
    public function ShowTrabajador($id)
	  {
        $trabajadores = $this->getDoctrine()->getRepository(TTrabajadores::class)->find($id);
        $proyectos = $this->getDoctrine()->getRepository(TProyecto::class)->findAll();
        $seguimientotrabajador = $this->getDoctrine()->getRepository(TSeguimientoProyectoTrabajadores::class)->findBy(
            array(
            'trabajadorid' => $id
         ));
    	$cargos = $this->getDoctrine()->getRepository(TCargo::class)->find($trabajadores->getCargoId());
           return $this->render('trabajador/mostrar_trabajador.html.twig', array('trabajadores' => $trabajadores,'cargos' => $cargos, 'seguimientotrabajador'=> $seguimientotrabajador, 'proyectos' => $proyectos)); 
    }

     /**
     * @IsGranted("ROLE_USER")
     * @Route("/empleado/listatrabajadores", name="lista_trajadores_empleado")
     */
    public function ListEmpleado()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $datouser = $this->getDoctrine()->getRepository(TTrabajadores::class)->findOneBy(
            array(
            'ci' => $user->getUsername()
         ));
         $trabajadores = $this->getDoctrine()->getRepository(TTrabajadores::class)->findAll();
         return $this->render('empleado_personal/trabajadores_asignados.html.twig', array('trabajadores' => $trabajadores));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/trabajador/delete/{id}", name="eliminar_trabajador")
    */
  public function DeleteTrabajador($id)
    {
        //$clientes = $this->getDoctrine()->getRepository(TCliente::class)->findOneBy(
        //array(
          //  'id_cliente' => $id
        //));
        $entityManager = $this->getDoctrine()->getManager();
        $trabajador = $entityManager->getRepository(TTrabajadores::class)->find($id);
        $trabajador->setEliminado(1);
        $entityManager->flush();
        $this->addFlash(
        'notice',
        '!El trabajador ha sido eliminado!');
        return $this->redirectToRoute('lista_trajadores');
    }
    /*SeguimientoTrabajador */
} 
