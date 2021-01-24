<?php

namespace App\Controller;

use App\Entity\Posts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use App\Form\PostsType;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/posts", name="posts")
 */
class PostsController extends AbstractController
{
    /**
     * @Route("/crear", name="crear")
     */
    public function crear(Request $request, SluggerInterface $slugger): Response
    {
        $post = new Posts();

        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $usuario = $this->getUser();
            $post->setIdCreador($usuario);

            /** @var UploadedFile $brochureFile */
            $fotoFile = $form->get('foto')->getData();

            // this condition is needed because the 'foto' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($fotoFile) {
                $originalFilename = pathinfo($fotoFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$fotoFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $fotoFile->move(
                        $this->getParameter('directorio_fotos'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    throw new \Exception('Ha ocurrido un error en la subida de la imagen');
                }

                $post->setFoto($newFilename);
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('dashboard');
        }

        return $this->render('posts/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
