<?php

namespace App\Controller;

use App\Entity\TAvanceProyecto;
use App\Entity\TGaleriaProyecto;
use App\Entity\TProyecto;

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
use Symfony\Component\OptionsResolver\OptionsResolver;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class GaleriaProyectoController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/galeria/{id}/{idp}", name="galeria_proyecto")
     *@Method({"GET","POST"})
     */
    public function UploadImageProyecto(Request $request, $id, $idp)
    {
    	$galeria = $this->getDoctrine()->getRepository(TGaleriaProyecto::class)->findBy(
    		array(
    			'avance_id' => $id
    		));
    	$proyecto = $this->getDoctrine()->getRepository(TProyecto::class)->findOneBy(
	    array(
	        'id_proyecto' => $idp
	    ));
        $avance = $this->getDoctrine()->getRepository(TAvanceProyecto::class)->findOneBy(
        array(
            'id' => $id
        ));
    	/* Nueva imagen*/
    	$galeria_images = new TGaleriaProyecto();
    	$form = $this->createFormBuilder( $galeria_images)
    	->add('avanceid', EntityType::class, array(
    		'class' => TAvanceProyecto::class,
    		'query_builder' => function (EntityRepository $er) use ($id){
    			return $er->createQueryBuilder('p')
    			->Where('p.id = :idd')
    			->setParameter('idd', $id);
    		},
    		'choice_label' => 'id',
    	))
    	->add('nombreimagen', FileType::class, array('label' => 'Subir la imagen:'))
        ->add('descripcion', TextareaType::class, array('label' => 'Descripción: '), array('attr' => array('class' => 'form-control')))
    	->add('save', SubmitType::class, array('label' => 'INGRESAR', 'attr' => array('class' => 'btn btn-success mt-3')))
    	->getForm();
    	$form->handleRequest($request);
    	if($form->isSubmitted() && $form->isValid())
    	{
        	// La variable $file guardará el PDF subido
    		/** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
    		$file = $galeria_images->getNombreImagen();
            // Generar un numbre único para el archivo antes de guardarlo
    			$fileName = md5(uniqid()).'.'.$file->guessExtension();
            // Mover el archivo al directorio donde se guardan los curriculums
    			try {
    				$file->move(
    					$this->getParameter('galeria_directory'),
    					$fileName
    				);
    			} catch (FileException $e) {
                // ... handle exception if something happens during file upload
    			}
            // Actualizar la propiedad Archivo para guardar el nombre de archivo PDF en lugar de sus contenidos
    		$galeria_images->setNombreImagen($fileName);
    		$galeria_images = $form->getData();
    		$entityManager = $this->getDoctrine()->getManager();
    		$entityManager->persist($galeria_images);
    		$entityManager->flush();    		
    		$this->addFlash(
            'notice',
            'Tus cambios se han guardado con exito!'
        	);            
    		return $this->redirectToRoute('desviar1', array('id' => $id, 'idp'=> $proyecto->getIdProyecto()));
    	}
        /*if($form->isSubmitted() && $form->isValid() == false)
        {
            $this->addFlash(
            'error',
            'No se han registrado cambios!'
            );
        }*/
    	/* Fin nuevo avance*/
    	return $this->render('galeria_proyecto/galeria.html.twig', array('galeria' => $galeria, 'avance'=>$avance, 'proyecto'=> $proyecto, 'form' => $form->createView()));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => TGaleriaProyecto::class,
        ));
    }

     /**
     * @Route("/desviar1/{id}/{idp}", name="desviar1")
     *@Method({"GET","POST"})
     */
    public function desviar1( $id, $idp)
    {
		 return $this->redirectToRoute('galeria_proyecto', array('id' => $id,'idp' => $idp));	
	}


    /**
    * @IsGranted("ROLE_ADMIN")
     * @Route("/galeria_admin/{id}/{idp}", name="galeria_admin")
     *@Method({"GET","POST"})
     */
    public function GaleriaAdmin( $id, $idp)
    {
        $galeria = $this->getDoctrine()->getRepository(TGaleriaProyecto::class)->findBy(
            array(
                'avance_id' => $id
            ));
        $proyecto = $this->getDoctrine()->getRepository(TProyecto::class)->findOneBy(
        array(
            'id_proyecto' => $idp
        ));

        $avance = $this->getDoctrine()->getRepository(TAvanceProyecto::class)->findOneBy(
        array(
            'id' => $id
        ));
        return $this->render('galeria_proyecto/galeria_admin.html.twig', array('avance'=>$avance,  'galeria' => $galeria, 'proyecto'=>$proyecto));
    }

    
     /**
    *@Route("/galeria/eliminar/{idi}/{id}/{idp}", name="eliminar_imagen_galeria")
    */
    public function DeleteImagenGaleria($idi, $id,$idp)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $imagen = $entityManager->getRepository(TGaleriaProyecto::class)->find($idi);
        
            $entityManager->remove($imagen);
            $entityManager->flush();
            $this->addFlash(
            'notice',
            'La imagen ha sido eliminada!');
            return $this->redirectToRoute('galeria_admin', array('id' => $id,'idp' => $idp));   
    }

    /**
    *@IsGranted("ROLE_USER")
    *@Route("/galeria_user/eliminar/{idi}/{id}/{idp}", name="eliminar_imagen_galeria_user")
    */
  public function DeleteImagenGaleriaTrabajador($idi, $id,$idp)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $imagen = $entityManager->getRepository(TGaleriaProyecto::class)->find($idi);
        
            $entityManager->remove($imagen);
            $entityManager->flush();
            $this->addFlash(
            'notice',
            'La imagen ha sido eliminada!');
            return $this->redirectToRoute('galeria_proyecto', array('id' => $id,'idp' => $idp));   
    }
}