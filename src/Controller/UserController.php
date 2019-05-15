<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\TTrabajadores;
use App\Entity\TCargo;
use App\Entity\TProyecto;
use App\Entity\TDetalleProyectoTrabajadores;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
{
	private $encodePassword;

	public function __construct(UserPasswordEncoderInterface $encodePassword)
    {
         $this->encodePassword = $encodePassword;
    }

    /**
     * @Route("/usuario/{id}", name="usuario")
     * @IsGranted("ROLE_ADMIN")
     */
    public function NewUser($id)
    {
    	$entityManager = $this->getDoctrine()->getManager();
        $trabajadores = $this->getDoctrine()->getRepository(TTrabajadores::class)->findOneBy(
        	array(
				'id_trabajador' => $id
			));
        $cargo = $this->getDoctrine()->getRepository(TCargo::class)->findOneBy(
        	array(
				'id_cargo' => $trabajadores->getCargoId()
			));
        $carg = $cargo->getRol();
        if($carg != 'ROLE_SIN_ACCESO')
       	{
	 		$user = new User();	
	        $user->setUsername($trabajadores->getCi());
	        $user->setPassword($this->encodePassword->encodePassword($user, $trabajadores->getCi()));
	        $user->setRoles($carg);
	        $entityManager->persist($user);
	        $entityManager->flush();
	    }
        return $this->redirectToRoute('lista_trajadores');
    }

	/**
     * @Route("/", name="usuario_perfil")
    */
    public function PerfilUser()
    {
    	$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
		$user = $this->getUser();
		$carg[] = $user->getRoles();
        $admin[] = 'ROLE_ADMIN';
        $empleado[] = 'ROLE_USER';
         if($user->getRoles() == $admin)
        {
            return $this->redirectToRoute('lista_trajadores');          
        }
        if($user->getRoles() == $empleado) 
        {
            $datouser = $this->getDoctrine()->getRepository(TTrabajadores::class)->findOneBy(
                array(
                'ci' => $user->getUsername()
                ));
            $cargo = $this->getDoctrine()->getRepository(TCargo::class)->find($datouser->getCargoId());

            return $this->render('perfil/perfil_trabajador.html.twig', array('user' => $user, 'datouser' => $datouser, 'cargo' => $cargo));         
        }
        return $this->redirectToRoute('logout');
    }

     /**
     * @Route("/usua", name="usua")
     */
    public function N()
    {
        $entityManager = $this->getDoctrine()->getManager();
        
        
        
            $user = new User(); 
            $empleado[] = 'ROLE_USER';

            $user->setUsername('pedro');
            $user->setRoles($empleado);
            $user->setPassword($this->encodePassword->encodePassword($user, 'pedro'));
            $entityManager->persist($user);
            $entityManager->flush();
        
        return $this->redirectToRoute('logout');
    }
}
