<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Usuarios;

class MostrarController extends AbstractController
{
    /**
     * @Route("/mostrar/{id}", name="mostrar")
     */
    public function index(Usuarios $usuario)
    {
        return $this->render('mostrar/index.html.twig', [
            'usuario' => $usuario,
        ]);
    }
}
