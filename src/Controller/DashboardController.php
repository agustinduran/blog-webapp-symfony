<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Knp\Component\Pager\PaginatorInterface;

use App\Entity\Posts;
use Symfony\Component\HttpFoundation\Request;

//use App\Repository\PostsRepository;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $em = $this->getDoctrine()->getManager();
        $postsQuery = $em->getRepository(Posts::class)->obtenerTodosLosPostsQuery();

        $pagination = $paginator->paginate(
            $postsQuery, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => '¡Bienvenido a Dashboard!',
            'pagination'      => $pagination
        ]);
    }
}
