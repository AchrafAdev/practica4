<?php

namespace App\Controller;

use App\Entity\Ciudades;
use App\Form\CiudadesType;
use App\Repository\CiudadesRepository;
//use App\Repository\UsuariosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ciudades")
 */
class CiudadesController extends AbstractController
{
    /**
     * @Route("/", name="ciudades_index", methods={"GET"})
     */
    public function index(CiudadesRepository $ciudadesRepository): Response
    {
        return $this->render('ciudades/index.html.twig', [
            'ciudades' => $ciudadesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ciudades_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ciudade = new Ciudades();
        $form = $this->createForm(CiudadesType::class, $ciudade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ciudade);
            $entityManager->flush();

            return $this->redirectToRoute('ciudades_index');
        }

        return $this->render('ciudades/new.html.twig', [
            'ciudade' => $ciudade,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ciudades_show", methods={"GET"})
     */
    public function show(Ciudades $ciudade): Response
    {
        return $this->render('ciudades/show.html.twig', [
            'ciudade' => $ciudade,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ciudades_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ciudades $ciudade): Response
    {
        $form = $this->createForm(CiudadesType::class, $ciudade);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ciudades_index');
        }

        return $this->render('ciudades/edit.html.twig', [
            'ciudade' => $ciudade,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ciudades_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Ciudades $ciudade): Response
    {

        if ($this->isCsrfTokenValid('delete'.$ciudade->getId(), $request->request->get('_token'))) {

            $entityManager = $this->getDoctrine()->getManager();
            //MODIFICADO POR YURIY 12.2.2020
            //Extraemos el ArrayCollection de usuarios de $this ciudad
            $usuariosCollection = $ciudade->getUsuarios();
            //$datos = $usuariosCollection.getValues();
            //if(empty($datos)){
            if(empty($usuariosCollection.toArray())){
                $entityManager->remove($ciudade);
                $entityManager->flush();
            }else{
                $this->addFlash('error', 'No puede borrar esta ciudad porque hay usuarios que viven allí');
                return $this->redirectToRoute('ciudades_edit',[
                    'id' => $ciudade->getId(),
                ]);

            }

            
        }

        return $this->redirectToRoute('ciudades_index');
    }
}
