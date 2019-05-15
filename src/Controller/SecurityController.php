<?php

namespace App\Controller;
use App\Entity\TProyecto;
use App\Entity\TGaleriaProyecto;
use App\Entity\TAvanceProyecto;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response ;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function Index(AuthenticationUtils $authenticationUtils): Response
    {
        $error= $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();
        $proyectos = $this->getDoctrine()->getRepository(TProyecto::class)->findBy(
         array(),
         array('id_proyecto' => 'DESC')
        );
        $galeria = $this->getDoctrine()->getRepository(TGaleriaProyecto::class)->findAll();
        $avances = $this->getDoctrine()->getRepository(TAvanceProyecto::class)->findAll();
        return $this->render('principal/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error, 
            'proyectos'=> $proyectos, 
            'galeria'=> $galeria, 
            'avances'=> $avances
        ]);
    }
    
    /**
    * @Route("/logout", name="logout")
    */
    public function logout() {}

     /**
     * @Route("/servicios", name="servicios")
     */
    public function NuestrosServicios(AuthenticationUtils $authenticationUtils): Response
    {
        $error= $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('principal/nuestros_servicios.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/proyectos_publico", name="proyectos_publico")
     */
    public function ShowProyectosPublico(AuthenticationUtils $authenticationUtils): Response
    {
        $error= $authenticationUtils->getLastAuthenticationError();
        $proyectos = $this->getDoctrine()->getRepository(TProyecto::class)->findBy(
         array(),
         array('id_proyecto' => 'DESC')
        );
        $galeria = $this->getDoctrine()->getRepository(TGaleriaProyecto::class)->findAll();
        $avances = $this->getDoctrine()->getRepository(TAvanceProyecto::class)->findAll();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('principal/proyectos.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error, 
            'proyectos'=> $proyectos, 
            'galeria'=> $galeria, 
            'avances'=> $avances
        ]);        
    }
}
