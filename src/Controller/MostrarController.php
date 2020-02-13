<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Usuarios;
use Symfony\Component\HttpFoundation\Request;

class MostrarController extends AbstractController
{
    /**
     * @Route("/mostrar", name="mostrar")
     */
    public function index( Usuarios $usuario)
    {
        // $usuario = new Usuarios();
        // $usuario=$request;
        // var_dump($request->query->get('nombre'));
        return $this->render('mostrar/index.html.twig', [
            'usuario' => $usuario,   
        ]);
    }
}
/**
 * , [
 *           'usuario' => $usuario,
 *       ]
 */