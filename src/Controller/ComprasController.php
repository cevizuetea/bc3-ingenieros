<?php
namespace App\Controller;

use App\Entity\TCompra;
use App\Entity\TProveedor;
use App\Entity\TDetalleCompra;
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
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ComprasController extends AbstractController
{
    /**
    * @IsGranted("ROLE_ADMIN")
     * @Route("/compras", name="compras")
    */
    public function ListCompras()
    {
       $compras = $this->getDoctrine()->getRepository(TCompra::class)->findAll();
       return $this->render('compras/compras.html.twig', array('compras' => $compras));
    }

    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/compra/new", name="nueva_compra")
    *@Method({"GET","POST"})
    */
    public function NewCompra(Request $request)
    {
      $compras = new TCompra();

      $form = $this->createFormBuilder($compras)
        ->add('numerofactura', IntegerType::class, array('label' => 'Número Factura '), array('attr' => array('class' => 'form-control')))
      	->add('proveedorid', EntityType::class, array(
                'class' => TProveedor::class,
                'choice_label' => 'nombre_proveedor',
                'label' => 'Proveedor: '))
		->add('fechaemision', DateType::class, [
            'widget' => 'single_text',
            // this is actually the default format for single_text
            'format' => 'yyyy-MM-dd',
            'label' => 'Fecha de ingreso: '
        ])	
        ->add('save', SubmitType::class, array('label' => 'INGRESAR', 'attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() )
        {
            $compras = $form->getData();
            $errores =0 ;
            if($compras->getNumeroFactura() < 0)
                {
                    $errores = $errores+1;
                    $this->addFlash(
                    'error_factura',
                    '* No se permiten valores negativos');  
                }
            if($errores == 0 && $form->isValid())
            {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($compras);
                $entityManager->flush();
                $this->addFlash(
                'notice',
                'Los datos han sido almacenados con éxito!');
                return $this->redirectToRoute('compras');
            }
        }
        return $this->render('compras/nueva_compra.html.twig', array('form' => $form->createView()));
    }

    /* EditCompra */
    
    /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/compra/edit/{id}", name="editar_compra")
    *@Method({"GET","POST"})
    */
    public function EditCompra(Request $request, $id)
    {
      $compras = new TCompra();
      $compras = $this->getDoctrine()->getRepository(TCompra::class)->find($id);
      $form = $this->createFormBuilder($compras)
        ->add('numerofactura', IntegerType::class, array('label' => 'Número Factura '), array('attr' => array('class' => 'form-control')))
        ->add('proveedorid', EntityType::class, array(
                'class' => TProveedor::class,
                'choice_label' => 'nombre_proveedor',
                'label' => 'Proveedor: '))
        ->add('fechaemision', DateType::class, [
            'widget' => 'single_text',
            // this is actually the default format for single_text
            'format' => 'yyyy-MM-dd',
            'label' => 'Fecha de ingreso: '
        ])  
        ->add('save', SubmitType::class, array('label' => 'MODIFICAR', 'attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() )
        {
            $compras = $form->getData();
            $errores =0 ;
            if($compras->getNumeroFactura() < 0)
                {
                    $errores = $errores+1;
                    $this->addFlash(
                    'error_factura',
                    '* No se permiten valores negativos');  
                }
            if($errores == 0 && $form->isValid())
            {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($compras);
                $entityManager->flush();
                $this->addFlash(
                'notice',
                'Tus cambios se han guardado con éxito!');
                return $this->redirectToRoute('compras');
            }
        }
        return $this->render('compras/editar_compra.html.twig', array('form' => $form->createView()));
    }

     /**
    *@IsGranted("ROLE_ADMIN")
    *@Route("/compra/show/{id}", name="mostrar_compra")
    *@Method({"GET","POST"})
    */
    public function ShowCompra($id)
    {
        $compra = $this->getDoctrine()->getRepository(TCompra::class)->find($id);
        $proveedor = $this->getDoctrine()->getRepository(TProveedor::class)->findAll();
        $detallecompra = $this->getDoctrine()->getRepository(TDetalleCompra::class)->findBy(
        array(
            'compra_id' => $id
        ));
           return $this->render('compras/mostrar_compra.html.twig', array('proveedor'=>$proveedor, 'compra' => $compra,'detallecompra' => $detallecompra )); 
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/detalle/compra/{id}", name="detalle_compras")
     *@Method({"GET","POST"})
     */
    public function AsignarDetalleCompra(Request $request, $id)
    {
        $compras = $this->getDoctrine()->getRepository(TCompra::class)->find($id);
        $proveedor = $this->getDoctrine()->getRepository(TProveedor::class)->find($compras->getProveedorId());
        $detallescompras = $this->getDoctrine()->getRepository(TDetalleCompra::class)->findBy(
    	array(
    		'compra_id' => $id
    	));
        $detallecompras = new TDetalleCompra();

        $form = $this->createFormBuilder($detallecompras)
        ->add('compraid', EntityType::class, array(
                'class' => TCompra::class,
                'query_builder' => function (EntityRepository $er) use ($id){
                        return $er->createQueryBuilder('c')
                        	->Where('c.id = :idd')
                        	->setParameter('idd', $id);                            
                    },
                'choice_label' => 'numerofactura',
            	))
        ->add('codigo', TextType::class, array('label' => 'Código:'), array('attr' => array('class' => 'form-control')))   
		->add('cantidad', IntegerType::class, array('label' => 'Cantidad: '), array('required' => false, 'attr' => array('class' => 'form-control')))
		->add('detalle', TextType::class, array('label' => 'Detalle:'), array('required' => false, 'attr' => array('class' => 'form-control')))      
        ->add('preciounitario', TextType::class, array('label' => 'Precio Unitario $'), array('required' => false, 'attr' => array('class' => 'form-control')))  
        ->add('tipo', ChoiceType::class,  array(
			    'choices'  => array(
			        ' Herramienta ' => 1,
			        ' Material ' => 2,
			    ),
			))

        ->add('save', SubmitType::class, array('label' => '.  ASIGNAR', 'attr' => array('class' => 'btn btn-success mt-3')))
        ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $detallecompras = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($detallecompras);
            $entityManager->flush();
            //modifica el campo precio total de la entidad Compras
            //si no encuentra el codigo agregar un mensaje de alerta que debe registrarse el produco primero en materiales
            $precio = $this->getDoctrine()->getRepository(TDetalleCompra::class)->find($detallecompras->getId());            
            $preciototal = $precio->getCantidad() * $precio->getPrecioUnitario();
            $precio->setPrecioUnitario($precio->getPrecioUnitario()/(1.12));      
            $precio->setPrecioTotal($preciototal/(1.12));	   
     	    $entityManager->flush();
     	    $cant = $precio->getCantidad();
     	    $pu = $precio->getPrecioUnitario();
     	    $pt = $precio->getPrecioTotal();
     	    //modificar material cantidad
     	    $tipo = $precio->getTipo();

                $material = $this->getDoctrine()->getRepository(TMaterial::class)->findOneBy(
                    array(
                        'codigo_material' => $precio->getCodigo()
                    )); 
     	    	if ($material && $tipo == 2) //tipo  material o herramienta
     	    	 {
     	    	 	$canttotal = $material->getCantidad();
     	    	 	$cantidadmaterial = $canttotal+$cant;  
     	    	 	$material->setCantidad($cantidadmaterial);      
     	    	 	$material->setPrecioTotal($material->getPrecioUnitario()*$cantidadmaterial);
     	    	 	$entityManager->flush();	
     	    	}
     	    	else
     	    	{
     	    		//mensaje de alerta que debe asignar a herramientas con sus debidas caracteristicas
     	    	}
            $this->addFlash(
            'notice',
            'El producto ha sido asignado!'
            );
            return $this->redirectToRoute('editar_valores_compra', array('idc' => $id, 'cant' => $cant, 'pu' => $pu, 'pt' => $pt));
        }
       return $this->render('compras/asignar_detalle_compra.html.twig', array('compras' => $compras,'proveedor' => $proveedor, 'form' => $form->createView(), 'detallescompras' => $detallescompras)); 
    }

    //MODIFICAR LOS CAMPOS DE LA FACTURA SUBTOTAL IVA Y TOTAL
     /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/editar/factura/compra/{idc}/{cant}/{pu}/{pt}", name="editar_valores_compra")
     *@Method({"GET","POST"})
     */
     public function EditarMaterialDetalle($idc, $cant, $pu, $pt)
     {
     	$entityManager = $this->getDoctrine()->getManager();
     	$compra = $entityManager->getRepository(TCompra::class)->find($idc);    
     	
        if(!$compra)
     	{
     	   	throw $this->createNotFoundException("Error Processing Request", $idc);     	    	
     	}
     	 $subtotal = $compra->getSubTotal() + $pt;
     	 $iva = $subtotal*(0.12);
     	 $total = $subtotal + $iva;
     	 $compra->setSubTotal($subtotal);
     	 $compra->setIva($iva);
     	 $compra->setTotal($total);			 
     	 $entityManager->flush(); 	    
       	 return $this->redirectToRoute('detalle_compras', array('id' => $idc));
     }

     //MODIFICAR LOS CAMPOS DE LA material SUBTOTAL IVA Y TOTAL CUANDO SE ELIMINA EL PRODUCTO
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/factura/compra/disminuir/{id}/{cant}/{pt}", name="editar_valores_compra_material")
     *@Method({"GET","POST"})
     */
     public function EditarMaterialDisminuir($id, $cant, $pt)
     {
     	$entityManager = $this->getDoctrine()->getManager();
     	$compraid = $entityManager->getRepository(TDetalleCompra::class)->find($id);
     	$idc = $compraid->getCompraId();
     	$tipo=$compraid->getTipo();
     	$entityManager = $this->getDoctrine()->getManager();
     	$compra = $entityManager->getRepository(TCompra::class)->find($idc);
     	$iddc= $compra->getId();    

     	if(!$compra)
     	{
     	  	throw $this->createNotFoundException("Error Processing Request", $idc);     	    	
     	}
     	//cambia la cantidad del subtotal de la factura
     	$subtotal = $compra->getSubTotal() - $pt;
     	$iva = $subtotal*(0.12);
     	$total = $subtotal + $iva;
  	    $compra->setSubTotal($subtotal);
   	    $compra->setIva($iva);
   	    $compra->setTotal($total);			  
   	    $entityManager->flush(); 	
    	   
   	    if($tipo == 2)
   	    {
			//modifica cantidad en la entidad materiales
				
			$material = $this->getDoctrine()->getRepository(TMaterial::class)->findOneBy(
					array(
						'codigo_material' => $compraid->getCodigo()
					)); 
	     	$canttotal = $material->getCantidad();
	        $cantidadmaterial = $canttotal-$cant;  
	     	$material->setCantidad($cantidadmaterial);      
	     	$material->setPrecioTotal($material->getPrecioUnitario()*$cantidadmaterial);
	     	$entityManager->flush();	
    	}
    	 //elimina de la tabla detalle factura el poducto    
 		$eliminarmaterial = $entityManager->getRepository(TDetalleCompra::class)->findBy(
		array(
			'id' => $id
		));    	    
     	foreach ($eliminarmaterial as $eliminarmateriales) {
		    $entityManager->remove($eliminarmateriales);
		}
		$entityManager->flush();
       	return $this->redirectToRoute('detalle_compras', array('id' => $iddc));
     }

    /**
    * @IsGranted("ROLE_ADMIN")
    *@Route("/compra/delete/{id}", name="eliminar_compra")
    */
    public function DeleteCompra($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $compra = $entityManager->getRepository(TCompra::class)->find($id);
        if($compra->getTotal() == 0)
        {
        $entityManager->remove($compra);
        $entityManager->flush();
        $this->addFlash(
        'notice',
        '!La compra ha sido eliminada!');
        }
        else
        {
            $this->addFlash(
            'error',
            '!Error al eliminar, la factura contiene detalles de compra!');
        }
        return $this->redirectToRoute('compras');
    }
}
