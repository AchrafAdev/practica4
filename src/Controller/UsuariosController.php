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
//Para comprobar si el usuario se ha logueado
use Symfony\Component\Security\Core\Security;

/**
 * @Route("/usuarios")
 */
class UsuariosController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

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

            if ($brochureFile) {
                $newFilename = uniqid().'.'.$brochureFile->guessExtension();

                // Movemos la foto al nuevo directorio
                try {
                    $brochureFile->move(
                        $this->getParameter('imagen_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $usuario->setImagen($newFilename);
            }

            $entityManager->persist($usuario);
            $entityManager->flush();
            //self::rename($newFilename,$usuario->getId(),$extension);
          
          

            /* Comprobamos si el usuario se ha logueado */
            $user = $this->security->getUser();
            if($user == null){
                return $this->redirectToRoute('index');
            }else{
                return $this->redirectToRoute('usuarios_show', [
                    'id' => $usuario->getId(),
                ]);
            }

            
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
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Usuarios $usuario): Response
    {
        if ($this->isCsrfTokenValid('delete'.$usuario->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($usuario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('usuarios_index');
    }

    public function removeImagen($imagen)
    {
        $filesystem = new Filesystem();
        $filesystem->remove($this->getParameter('imagen_directory').'/'.$imagen);
    }

}
