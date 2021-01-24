<?php

namespace App\Controller;

use App\Entity\Profesion;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\ProfesionRepository;

class RegistroController extends AbstractController
{
    /**
     * @Route("/registro", name="registro")
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $plainPassword = $form['password']->getData();
            $user->setPassword($passwordEncoder->encodePassword($user, $plainPassword));
            //
            //$profesionesRepo = new ProfesionRepository();
            $profesion = new Profesion();
            $profesion->setNombre('Desarrollador de Software');
            $em->persist($profesion);

            $user->setIdProfesion($profesion);
            //
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Se ha registrado completamente');
            return $this->redirectToRoute('registro');
        }

        return $this->render('registro/index.html.twig', 
        [
            'formulario' => $form->createView()
        ]);
    }
}
