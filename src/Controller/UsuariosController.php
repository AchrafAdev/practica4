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
use Symfony\Component\Filesystem\Filesystem;

/**
 * @Route("/usuarios")
 */
class UsuariosController extends AbstractController
{
    /**
     * @Route("/", name="usuarios_index", methods={"GET"})
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
            
           
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                //$newFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                //this is needed to safely include the file name as part of the URL
                //$safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $id.'.'.$brochureFile->guessExtension();
              

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('imagen_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $usuario->setImagen($newFilename);
            }

            $entityManager->persist($usuario);
            $entityManager->flush();
            //self::rename($newFilename,$usuario->getId(),$extension);
            
            /* Comprobamos si el usuario se ha logueado */
            $user = $this->security->getUser();
            if($user == null){
                return $this->render('mostrar/index.html.twig', [
                    'usuario' => $usuario,
                ]);
            }else{
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
     */
    public function show(Usuarios $usuario): Response
    {
        return $this->render('usuarios/show.html.twig', [
            'usuario' => $usuario,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="usuarios_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Usuarios $usuario): Response
    {
        $form = $this->createForm(UsuariosType::class, $usuario);
        $form->handleRequest($request);
        //$oldImagePath = $usuario->getImagen();

        if ($form->isSubmitted() && $form->isValid()) {

             /** @var UploadedFile $brochureFile */
             $brochureFile = $form->get('imagen')->getData();
             //self::removeImagen($oldImagePath); 

             // this condition is needed because the 'brochure' field is not required
             // so the PDF file must be processed only when a file is uploaded
             if ($brochureFile) {
                 
                 // this is needed to safely include the file name as part of the URL
                 
                 $newFilename = $usuario->getId().'.'.$brochureFile->guessExtension();
 
                 // Move the file to the directory where brochures are stored
                 try {
                     $brochureFile->move(
                         $this->getParameter('imagen_directory'),
                         $newFilename
                     );
                 } catch (FileException $e) {
                     // ... handle exception if something happens during file upload
                 }
 
                 // updates the 'brochureFilename' property to store the PDF file name
                 // instead of its contents
                 $usuario->setImagen($newFilename);
            } 
              // else{

                  //  $usuario->setImagen(false);
              //  }
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
