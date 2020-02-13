<?php

namespace App\Controller;

use App\Entity\Aficiones;
use App\Form\AficionesType;
use App\Repository\AficionesRepository;
use App\Repository\UsuariosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/aficiones")
 */
class AficionesController extends AbstractController
{
    /**
     * @Route("/", name="aficiones_index", methods={"GET"})
     */
    public function index(AficionesRepository $aficionesRepository): Response
    {
        return $this->render('aficiones/index.html.twig', [
            'aficiones' => $aficionesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="aficiones_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $aficione = new Aficiones();
        $form = $this->createForm(AficionesType::class, $aficione);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($aficione);
            $entityManager->flush();

            return $this->redirectToRoute('aficiones_index');
        }

        return $this->render('aficiones/new.html.twig', [
            'aficione' => $aficione,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="aficiones_show", methods={"GET"})
     */
    public function show(Aficiones $aficione): Response
    {
        return $this->render('aficiones/show.html.twig', [
            'aficione' => $aficione,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="aficiones_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Aficiones $aficione): Response
    {
        $form = $this->createForm(AficionesType::class, $aficione);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('aficiones_index');
        }

        return $this->render('aficiones/edit.html.twig', [
            'aficione' => $aficione,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="aficiones_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Aficiones $aficione, UsuariosRepository $usuariosRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$aficione->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();

            //MODIFICADO POR YURIY 12.2.2020
            $usuarios = $usuariosRepository->findAll();
            //Comprobamos si el array de usuarios esta vacio
            if(empty($usuarios)){
                 //Como esta vacio borramos
                 $entityManager->remove($aficione);
                 $entityManager->flush();
                 $this->addFlash('success', $aficione->getNombre().' eliminada satisfactoriamente');
            }else{
                //Recorremos todos los usuarios
                foreach($usuarios as $usuario){
                    //ArrayCollection de aficiones
                    $aficiones = $usuario->getAficiones();
                        foreach($aficiones as $aficion){
                            if($aficion->getId() == $aficione->getId()){
                                $this->addFlash('error', 'No puede borrar esta aficion porque hay usuario con esa aficion');
                                return $this->redirectToRoute('aficiones_edit',[
                                    'id' => $aficione->getId(),
                                ]);
                            }else{
                                //Borramos...
                                $entityManager->remove($aficione);
                                $entityManager->flush();
                                $this->addFlash('success', $aficione->getNombre().' eliminada satisfactoriamente');
                           }
                        }
                    
                }  
            }  
        }

        return $this->redirectToRoute('aficiones_index');
    }
}
