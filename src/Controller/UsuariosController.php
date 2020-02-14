<?php

namespace App\Controller;

use App\Entity\Usuarios;
use App\Form\UsuariosType;
use App\Repository\UsuariosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @Route("/usuarios")
 */
class UsuariosController extends AbstractController
{
    /**
     * @Route("/", name="usuarios_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(UsuariosRepository $usuariosRepository): Response
    {
        return $this->render('usuarios/index.html.twig', [
            'usuarios' => $usuariosRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="usuarios_new", methods={"GET","POST"})
     */
    public function new(Request $request, UsuariosRepository $usuariosRepository): Response
    {
        
        $usuario = new Usuarios();
        $form = $this->createForm(UsuariosType::class, $usuario);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            /** @var UploadedFile $brochureFile */
            $brochureFile = $form->get('imagen')->getData();
            $usuarios = $usuariosRepository->findAll();
            if(empty($usuarios)){
                $id = 1;
            }else{
                $lastQuestion = $usuariosRepository->findOneBy([], ['id' => 'desc']);
                $id = $lastQuestion->getId()+1;
            }
            
            if ($brochureFile) {
                $newFilename = $id.'.'.$brochureFile->guessExtension();
              

                // Movemos la foto al nuevo directorio
                try {
                    $brochureFile->move(
                        $this->getParameter('imagen_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // Movemos la foto al nuevo directorio
                $usuario->setImagen($newFilename);
            }

            $entityManager->persist($usuario);
            $entityManager->flush();
            //self::rename($newFilename,$usuario->getId(),$extension);
            
            /* Comprobamos si el usuario se ha logueado */
            $user = $this->getUser();
            if($user == null){
                $this->addFlash('success', $usuario->getNombre().' agregado satisfactoriamente');
                return $this->render('mostrar/index.html.twig', [
                    'usuario' => $usuario,
                ]);
            }else{
                $this->addFlash('success', $usuario->getNombre().' agregado satisfactoriamente');
                return $this->redirectToRoute('usuarios_show', [
                    'id' => $usuario->getId(),
                ]);
            }

            return $this->redirectToRoute('usuarios_index');
        }

        return $this->render('usuarios/new.html.twig', [
            'usuario' => $usuario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="usuarios_show", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function show(Usuarios $usuario): Response
    {
        return $this->render('usuarios/show.html.twig', [
            'usuario' => $usuario,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="usuarios_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Usuarios $usuario): Response
    {
        $form = $this->createForm(UsuariosType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

             /** @var UploadedFile $brochureFile */
             $brochureFile = $form->get('imagen')->getData();
             if ($brochureFile) {
                 
                 $newFilename = $usuario->getId().'.'.$brochureFile->guessExtension();
 
                 // Movemos la imagen al nuevo directorio
                 try {
                     $brochureFile->move(
                         $this->getParameter('imagen_directory'),
                         $newFilename
                     );
                 } catch (FileException $e) {
                     // ... handle exception if something happens during file upload
                 }
 
                 //Establecemos la imagen al usuario
                 $usuario->setImagen($newFilename);
            } 
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('usuarios_index');
               
        
        }

        return $this->render('usuarios/edit.html.twig', [
            'usuario' => $usuario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="usuarios_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Usuarios $usuario): Response
    {
        if ($this->isCsrfTokenValid('delete'.$usuario->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            self::removeImagen($usuario->getImagen());
            $entityManager->remove($usuario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('usuarios_index');
    }


    /**
     * @Route("/borrar/{imagen}",name="borrar_foto")
     * @IsGranted("ROLE_ADMIN")
     */

     public function borrarFoto ($imagen, Usuarios $usuario)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $filesystem = new Filesystem();
        $filesystem->remove($this->getParameter('imagen_directory').'/'.$imagen);
        $usuario->setImagen(null);
        //$entityManager->persist($usuario);
        $entityManager->flush();
    
        return $this->redirectToRoute('usuarios_index');
    }




    public function removeImagen($imagen)
    {
        $filesystem = new Filesystem();
        $filesystem->remove($this->getParameter('imagen_directory').'/'.$imagen);
    }

}
