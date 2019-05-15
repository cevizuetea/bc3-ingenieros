<?php

namespace App\Controller;

use App\Entity\TProyecto;
use App\Entity\TCliente;
use App\Entity\TEstadoProyecto;
use App\Entity\TTrabajadores;
use App\Entity\TAvanceProyecto;
use App\Entity\TGaleriaProyecto;

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
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class AvanceProyectoController extends AbstractController
{
    /**
    
    *@Route("/avance/proyecto/{id}", name="avance_proyecto")
    *@Method({"GET","POST"})
    */
    public function NewAvanceProyecto(Request $request, $id)
    {
        $avancesproyectos = $this->getDoctrine()->getRepository(TAvanceProyecto::class)->findBy(
	    array(
	        'proyecto_id' => $id
	    ));
		$proyecto = $this->getDoctrine()->getRepository(TProyecto::class)->findOneBy(
	    array(
	        'id_proyecto' => $id
	    ));

	    /* Nuevo avance*/
	    $avances = new TAvanceProyecto();

        $form = $this->createFormBuilder($avances)
      	
      	 ->add('proyectoid', EntityType::class, array(
                'class' => TProyecto::class,
                'query_builder' => function (EntityRepository $er) use ($id){
                        return $er->createQueryBuilder('p')
                        	->Where('p.id_proyecto = :idd')
                        	->setParameter('idd', $id);
                   },
                'choice_label' => 'nombre_proyecto',
            	))
        ->add('archivoavance', FileType::class, array('label' => 'Avance (PDF):'))
		->add('fechaavance', DateType::class, [
            'widget' => 'single_text',
            // this is actually the default format for single_text
            'format' => 'yyyy-MM-dd',
            'label' => 'Fecha de avance: '
        ])
        ->add('observaciones', TextareaType::class, array('label' => 'Observaciones: '), array('required' => false, 'attr' => array('class' => 'form-control')))
        ->add('save', SubmitType::class, array('label' => 'INGRESAR', 'attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
        	// La variable $file guardará el PDF subido
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $avances->getArchivoAvance();

            // Generar un numbre único para el archivo antes de guardarlo
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Mover el archivo al directorio donde se guardan los curriculums
            try {

                $file->move(
                    $this->getParameter('avances_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // Actualizar la propiedad Archivo para guardar el nombre de archivo PDF en lugar de sus contenidos
            $avances->setArchivoAvance($fileName);


            $avances = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($avances);
            $entityManager->flush();
             $this->addFlash(
            'notice',
            'Tus cambios se han guardado con exito!'
            );
            return $this->redirectToRoute('desviar', array('id' => $id));
        }
	    /* Fin nuevo avance*/
      	return $this->render('avance_proyecto/avances_proyecto.html.twig', array('avancesproyectos' => $avancesproyectos, 'form' => $form->createView(), 'proyecto' => $proyecto));
    }

    /**
     * @Route("/desviar/{id}", name="desviar")
     *@Method({"GET","POST"})
     */
    public function desviar( $id)
    {
		 return $this->redirectToRoute('avance_proyecto', array('id' => $id));	
	}


    /**
    *@Route("/avance/delete/{ida}/{id}", name="eliminar_avance")
    */
    public function DeleteAvanceProyecto($ida,$id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $avance_proyecto = $entityManager->getRepository(TAvanceProyecto::class)->find($ida);
        $galeria = $this->getDoctrine()->getRepository(TGaleriaProyecto::class)->findBy(
            array(
                'avance_id' => $ida
            )); 
        if($galeria)
        {
            $this->addFlash(
            'error',
            'El avance no se pudo eliminar, existen imagenes en galería!');
        }
        else
        {
            $entityManager->remove($avance_proyecto);
            $entityManager->flush();
            $this->addFlash(
            'notice',
            'El avance se ha sido eliminado!');
        }        
        return $this->redirectToRoute('avance_proyecto', array('id' => $id));
    }
}
