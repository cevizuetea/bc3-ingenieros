<?php

namespace App\Controller;

use App\Entity\TProyecto;
use App\Entity\Therramienta;
use App\Entity\TCliente;
use App\Entity\TEstadoProyecto;
use App\Entity\TTrabajadores;
use App\Entity\TAvanceProyecto;
use App\Entity\TDetalleProyectoHerramientas;
use App\Entity\TDetalleProyectoMateriales;
use App\Entity\TDetalleProyectoTrabajadores;
use App\Entity\TSeguimientoProyectoHerramientas;
use App\Entity\TSeguimientoProyectoMateriales;
use App\Entity\TSeguimientoProyectoTrabajadores;

use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Mime\MimeTypes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ProyectoController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/proyectos", name="lista_proyectos")
     */
     public function ListProyectos()
    {
         $proyectos = $this->getDoctrine()->getRepository(TProyecto::class)->findBy(
         array(),
         array('id_proyecto' => 'DESC')
        );
      	 return $this->render('proyecto/proyectos.html.twig', array('proyectos' => $proyectos));

    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/proyecto/new", name="nuevo_prooyecto")
    *@Method({"GET","POST"})
    */
   public function NewProyecto(Request $request)
    {
      $proyectos = new TProyecto();
      $form = $this->createFormBuilder($proyectos)
      	->add('clienteid', EntityType::class, array(
                'class' => TCliente::class,
                'choice_label' => 'nombrecliente',
                'label' => 'Cliente: '))
      	 ->add('trabajadorid', EntityType::class, array(
                'label' => 'Asignar un trabajador responsable:',
                'class' => TTrabajadores::class,
                'query_builder' => function (EntityRepository $er){
                        return $er->createQueryBuilder('t')
                            ->Where('t.disponibilidad = 0');                            
                    },
                'choice_label' => 'nombres'))
        ->add('nombreproyecto', TextType::class, array('label' => 'Nombre del proyecto '), array('attr' => array('class' => 'form-control')))
        ->add('direccionproyecto', TextType::class, array('label' => 'Dirección: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('archivocotizacion', FileType::class, array('label' => 'Cotizacion (PDF):'))
		->add('fechainicio', DateType::class, [
            'widget' => 'single_text',
            // this is actually the default format for single_text
            'format' => 'yyyy-MM-dd',
            'label' => 'Fecha de inicio del proyecto'
        ])		
        ->add('fechafin', DateType::class, [
            'widget' => 'single_text',
            // this is actually the default format for single_text
            'format' => 'yyyy-MM-dd',
            'label' => 'Fecha de finalización del proyecto '
        ])
		->add('estadoid', EntityType::class, array(
                'class' => TEstadoProyecto::class,
                'choice_label' => 'nombreestadoproyecto',
                'label' => 'Estado del Proyecto: '))       
        ->add('save', SubmitType::class, array('label' => 'INGRESAR', 'attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() )
        {   
            $proyectos = $form->getData();
            $errores = 0;
            if($proyectos->getFechaFin() < $proyectos->getFechaInicio())
                {   
                    $errores = $errores+1;
                    $this->addFlash(
                    'error_fecha',
                    '* La fecha de fin debe ser mayor a la de inicio del proyecto');                            
                }
            if($errores == 0 && $form->isValid())
            {
            	// La variable $file guardará el PDF subido
                /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
                $file = $proyectos->getArchivoCotizacion();
                // Generar un numbre único para el archivo antes de guardarlo
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                // Mover el archivo al directorio donde se guardan los curriculums
                try {
                    $file->move(
                        $this->getParameter('projects_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                // Actualizar la propiedad Archivo para guardar el nombre de archivo PDF en lugar de sus contenidos
                $proyectos->setArchivoCotizacion($fileName);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($proyectos);
                $entityManager->flush();
                $trabajadores = $entityManager->getRepository(TTrabajadores::class)->find($proyectos->getTrabajadorId());
                $trabajadores->setDisponibilidad(1);
                $entityManager->flush();
                $this->addFlash(
                'notice',
                'Los datos han sido almacenados con éxito!');
                return $this->redirectToRoute('lista_proyectos');
            }
        }
        return $this->render('proyecto/nuevo_proyecto.html.twig', array('form' => $form->createView()));
    }

    /**
    * @return string
    */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/proyecto/edit/{id}", name="editar_prooyecto")
    *@Method({"GET","POST"})
    */

   public function EditProyecto(Request $request, $id)
    {
        $proyectos = new TProyecto();
        $proyectos = $this->getDoctrine()->getRepository(TProyecto::class)->find($id);       
        $proyectos->setArchivoCotizacion(
                new File($this->getParameter('projects_directory').'/'.$proyectos->getArchivoCotizacion())
            );
        $form = $this->createFormBuilder($proyectos)
        ->add('clienteid', EntityType::class, array(
                'class' => TCliente::class,
                'choice_label' => 'nombrecliente',
                'label' => 'Cliente: '))
         ->add('trabajadorid', EntityType::class, array(
                'label' => 'Asignar un trabajador responsable:',
                'class' => TTrabajadores::class,
                'query_builder' => function (EntityRepository $er){
                        return $er->createQueryBuilder('t')
                            ->Where('t.disponibilidad = 0');                            
                    },
                'choice_label' => 'nombres'))
        ->add('nombreproyecto', TextType::class, array('label' => 'Nombre del proyecto '), array('attr' => array('class' => 'form-control')))
        ->add('direccionproyecto', TextType::class, array('label' => 'Dirección: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('fechainicio', DateType::class, [
            'widget' => 'single_text',
            // this is actually the default format for single_text
            'format' => 'yyyy-MM-dd',
            'label' => 'Fecha de inicio del proyecto'
        ])      
        ->add('fechafin', DateType::class, [
            'widget' => 'single_text',
            // this is actually the default format for single_text
            'format' => 'yyyy-MM-dd',
            'label' => 'Fecha de finalización del proyecto '
        ])
        ->add('estadoid', EntityType::class, array(
                'class' => TEstadoProyecto::class,
                'choice_label' => 'nombreestadoproyecto',
                'label' => 'Estado del Proyecto: '))
       
        ->add('save', SubmitType::class, array('label' => 'MODIFICAR', 'attr' => array('class' => 'btn btn-success mt-3')))
         ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted())
        {   
            $proyectos = $form->getData();
            $errores = 0;
            if($proyectos->getFechaFin() < $proyectos->getFechaInicio())
                {   
                    $errores = $errores+1;
                    $this->addFlash(
                    'error_fecha',
                    '* La fecha de fin debe ser mayor a la de inicio del proyecto');                            
                }
            if ($errores==0  && $form->isValid())
            {
            // La variable $file guardará el PDF subido
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $proyectos->getArchivoCotizacion();
            // Generar un numbre único para el archivo antes de guardarlo
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            // Mover el archivo al directorio donde se guardan los curriculums
            try {
                $file->move(
                    $this->getParameter('projects_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            // Actualizar la propiedad Archivo para guardar el nombre de archivo PDF en lugar de sus contenidos
            $proyectos->setArchivoCotizacion($fileName);
            $proyectos = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($proyectos);
            $entityManager->flush();
            $this->addFlash(
            'notice',
            'Tus cambios se han guardado con exito!'
            );          
            return $this->redirectToRoute('lista_proyectos');
            }
        }
        return $this->render('proyecto/editar_proyecto.html.twig', array('form' => $form->createView()));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/proyecto/show/{id}", name="mostrar_prooyecto")
    *@Method({"GET","POST"})
    */
    public function ShowProyecto(Request $request, $id)
    {
        $proyectos = $this->getDoctrine()->getRepository(TProyecto::class)->find($id);
        $cliente = $this->getDoctrine()->getRepository(TCliente::class)->find($proyectos->getClienteId());
        $estados = $this->getDoctrine()->getRepository(TEstadoProyecto::class)->find($proyectos->getEstadoId());
        $trabajador = $this->getDoctrine()->getRepository(TTrabajadores::class)->find($proyectos->getTrabajadorId());
        $herramientasasignadas = $this->getDoctrine()->getRepository(TDetalleProyectoHerramientas::class)->findBy(
        array(
            'proyecto_id' => $id
        ));
        $herramientasasseguimiento = $this->getDoctrine()->getRepository(TSeguimientoProyectoHerramientas::class)->findBy(
        array(
            'proyectoid' => $id,
            'eliminado' => 1,
        ));
        $materialesasignados = $this->getDoctrine()->getRepository(TDetalleProyectoMateriales::class)->findBy(
        array(
            'proyectoid' => $id
        ));
        $materialesseguimiento = $this->getDoctrine()->getRepository(TSeguimientoProyectoMateriales::class)->findBy(
        array(
            'proyectoid' => $id,
            'eliminado' => 1
        ));
        $trabajadoresasignados = $this->getDoctrine()->getRepository(TDetalleProyectoTrabajadores::class)->findBy(
        array(
            'idproyecto' => $id
        ));
        $trabajadoresseguimiento = $this->getDoctrine()->getRepository(TSeguimientoProyectoTrabajadores::class)->findBy(
        array(
            'proyectoid' => $id,
            'eliminado' => 1,
        ));
        $avancesproyecto = $this->getDoctrine()->getRepository(TAvanceProyecto::class)->findBy(
        array(
            'proyecto_id' => $id
        ));   
       return $this->render('proyecto/mostrar_proyecto.html.twig', array('trabajadoresseguimiento'=>$trabajadoresseguimiento,'materialesseguimiento'=>$materialesseguimiento,'herramientasasseguimiento' => $herramientasasseguimiento, 'proyectos' => $proyectos,'cliente' => $cliente, 'estados' => $estados, 'trabajador' => $trabajador, 'avancesproyecto' => $avancesproyecto, 'herramientasasignadas'=>$herramientasasignadas, 'materialesasignados'=>$materialesasignados,'trabajadoresasignados'=>$trabajadoresasignados)); 
    }

     /**
     * @IsGranted("ROLE_USER")
     * @Route("/proyectos/user", name="lista_proyectos_trabajador")
     */
     public function ListProyectosTrabajador()
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $datouser = $this->getDoctrine()->getRepository(TTrabajadores::class)->findOneBy(
                array(
                'ci' => $user->getUsername()
                ));
        $idtrabajador = $datouser->getIdTrabajador();
         $proyectos = $this->getDoctrine()->getRepository(TProyecto::class)->findBy(
            array(
                'trabajador_id' => $idtrabajador
            ));
         return $this->render('proyecto/proyectos_trabajador.html.twig', array('proyectos' => $proyectos));

    }

    /**
    *@IsGranted("ROLE_USER")
    *@Route("/proyecto_user/{id}", name="mostrar_prooyecto_user")
    *@Method({"GET","POST"})
    */
    public function ListAvanceProyectoTrabajador(Request $request, $id)
    {
        $proyectos = $this->getDoctrine()->getRepository(TProyecto::class)->find($id);
        $cliente = $this->getDoctrine()->getRepository(TCliente::class)->find($proyectos->getClienteId());
        $estados = $this->getDoctrine()->getRepository(TEstadoProyecto::class)->find($proyectos->getEstadoId());
        $trabajador = $this->getDoctrine()->getRepository(TTrabajadores::class)->find($proyectos->getTrabajadorId());
        $herramientasasignadas = $this->getDoctrine()->getRepository(TDetalleProyectoHerramientas::class)->findBy(
        array(
            'proyecto_id' => $id
        ));
        $herramientasasseguimiento = $this->getDoctrine()->getRepository(TSeguimientoProyectoHerramientas::class)->findBy(
        array(
            'proyectoid' => $id,
            'eliminado' => 1,
        ));
        $materialesasignados = $this->getDoctrine()->getRepository(TDetalleProyectoMateriales::class)->findBy(
        array(
            'proyectoid' => $id
        ));
        $materialesseguimiento = $this->getDoctrine()->getRepository(TSeguimientoProyectoMateriales::class)->findBy(
        array(
            'proyectoid' => $id,
            'eliminado' => 1
        ));
        $trabajadoresasignados = $this->getDoctrine()->getRepository(TDetalleProyectoTrabajadores::class)->findBy(
        array(
            'idproyecto' => $id
        ));
        $trabajadoresseguimiento = $this->getDoctrine()->getRepository(TSeguimientoProyectoTrabajadores::class)->findBy(
        array(
            'proyectoid' => $id,
            'eliminado' => 1,
        ));
        $avancesproyecto = $this->getDoctrine()->getRepository(TAvanceProyecto::class)->findBy(
        array(
            'proyecto_id' => $id
        ));
           return $this->render('proyecto/mostrar_proyecto_trabajador.html.twig', array('trabajadoresseguimiento'=>$trabajadoresseguimiento,'materialesseguimiento'=>$materialesseguimiento,'herramientasasseguimiento' => $herramientasasseguimiento, 'proyectos' => $proyectos,'cliente' => $cliente, 'estados' => $estados, 'trabajador' => $trabajador, 'avancesproyecto' => $avancesproyecto, 'herramientasasignadas'=>$herramientasasignadas, 'materialesasignados'=>$materialesasignados,'trabajadoresasignados'=>$trabajadoresasignados)); 
    }

    /**
    *@Route("/volver/{id}", name="volver")
    *@Method({"GET","POST"})
    */
    public function volver(Request $request, $id)
    {
        return $this->redirectToRoute('mostrar_prooyecto', array('id' => $id));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/proyecto/delete/{id}", name="eliminar_proyecto")
    */
    public function DeleteProyecto($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $proyecto = $entityManager->getRepository(TProyecto::class)->find($id);
        $herramientasasiganadas = $this->getDoctrine()->getRepository(TDetalleProyectoHerramientas::class)->findBy(
            array(
                'proyecto_id' => $id
            )); 
        $materialesasiganados = $this->getDoctrine()->getRepository(TDetalleProyectoMateriales::class)->findBy(
        array(
            'proyectoid' => $id
        ));  
        $trabajadoresasignados = $this->getDoctrine()->getRepository(TDetalleProyectoTrabajadores::class)->findBy(
        array(
            'idproyecto' => $id
        ));    
        if($herramientasasiganadas || $materialesasiganados || $trabajadoresasignados)
        {
            $this->addFlash(
            'error',
            'El proyecto no se pudo eliminar, existen herramientas, materiales y trabajadores asignados!');
        }
        else
        {
            $entityManager->remove($proyecto);
            $entityManager->flush();
            $this->addFlash(
            'notice',
            'El proyecto ha sido eliminado!');
        }        
        return $this->redirectToRoute('lista_proyectos');
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/reporte/proy_estado/{id}", name="proyecto_estado")
    */
  public function ReporteProyectoPorEstado($id)
    {
        
        $entityManager = $this->getDoctrine()->getManager();       
        $estados = $this->getDoctrine()->getRepository(TEstadoProyecto::class)->findAll();
        $estado = $this->getDoctrine()->getRepository(TEstadoProyecto::class)->find($id);
        $proyectos = $this->getDoctrine()->getRepository(TProyecto::class)->findBy(
            array(
                'estado_id'=> $estado->getIdEstadoProyecto()));
         return $this->render('reportes/reporte_proyectos_segun_su_estado.html.twig', array('estados' => $estados,'estado' => $estado,'proyectos'=> $proyectos));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/reporte/proy_anio", name="proyecto_anio")
    */
  public function ReporteProyectoPorAnio()
    {
        $entityManager = $this->getDoctrine()->getManager();       
        //$proyectos = $this->getDoctrine()->getRepository(TProyecto::class)->findBy(
        //    array(
          //      'fecha_inicio' => array('year' => $id))
        //);
        $proyectos = $this->getDoctrine()->getRepository(TProyecto::class)->findAll();
        return $this->render('reportes/reporte_proyectos_por_anio.html.twig', array('proyectos'=> $proyectos));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/reporte/proy_materiales/{id}", name="proyecto_materiales")
    */
    public function ReporteProyectoMaterialesAsignados($id)
    {
        $entityManager = $this->getDoctrine()->getManager();     
        $proyecto = $this->getDoctrine()->getRepository(TProyecto::class)->find($id);
        $proyectos = $this->getDoctrine()->getRepository(TProyecto::class)->findAll();
        $materialesasignados = $this->getDoctrine()->getRepository(TSeguimientoProyectoMateriales::class)->findBy(
        array(
            'proyectoid' => $id,
            'eliminado' => 1
        ));
         return $this->render('reportes/reporte_proyectos_materiales.html.twig', array('proyectos'=> $proyectos, 'proyecto'=> $proyecto, 'materialesasignados' => $materialesasignados));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/reporte/proy_herramientas/{id}", name="proyecto_herramientas")
    */
    public function ReporteProyectoHerramientasAsignadas($id)
    {
        $entityManager = $this->getDoctrine()->getManager();     
        $proyecto = $this->getDoctrine()->getRepository(TProyecto::class)->find($id);
        $proyectos = $this->getDoctrine()->getRepository(TProyecto::class)->findAll();
        $herramientasasignadas = $this->getDoctrine()->getRepository(TSeguimientoProyectoHerramientas::class)->findBy(
        array(
            'proyectoid' => $id,
            'eliminado' => 1,
        ));
         return $this->render('reportes/reporte_proyectos_herramientas.html.twig', array('proyectos'=> $proyectos, 'proyecto'=> $proyecto, 'herramientasasignadas' => $herramientasasignadas));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/reporte/proy_trabajadores/{id}", name="proyecto_trabajadores")
    */
    public function ReporteProyectoTrabajadoresAsignados($id)
    {
        $entityManager = $this->getDoctrine()->getManager();     
        $proyecto = $this->getDoctrine()->getRepository(TProyecto::class)->find($id);
        $trabajador = $this->getDoctrine()->getRepository(TTrabajadores::class)->find($proyecto->getTrabajadorId());
        $proyectos = $this->getDoctrine()->getRepository(TProyecto::class)->findAll();
        $trabajadoresasignados = $this->getDoctrine()->getRepository(TSeguimientoProyectoTrabajadores::class)->findBy(
        array(
            'proyectoid' => $id,
            'eliminado' => 1,
        ));
         return $this->render('reportes/reporte_proyectos_trabajadores.html.twig', array('proyectos'=> $proyectos, 'proyecto'=> $proyecto, 'trabajador'=> $trabajador,'trabajadoresasignados' => $trabajadoresasignados));
    }
    //EditEstadoProyecto 
}
