<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PrincipalController extends AbstractController
{
    /**
     * @Route("/l", name="principal")
     */
    public function index()
    {
        return $this->render('principal/index.html.twig');
    }

    /**
     * @Route("/empleado", name="empleado")
     */
    public function indexempleado()
    {
        return $this->render('base_empleado.html.twig');
        
    }

    

   
}
