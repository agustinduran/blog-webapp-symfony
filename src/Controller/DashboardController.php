<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Posts;

//use App\Repository\PostsRepository;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository(Posts::class)->obtenerTodosLosPosts();
        
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => '¡Bienvenido a Dashboard!',
            'posts' => $posts
        ]);
    }
}
