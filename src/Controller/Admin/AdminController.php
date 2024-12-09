<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AdminController extends AbstractController
{
   
    #[Route('/admin', name: 'app_admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        return $this->render('admin/admin.html.twig');
    }

    #[Route('/admin/add_movies', name: 'app_admin_add_movies')]
    #[IsGranted('ROLE_ADMIN')]
    public function addMovies(): Response
    {
        return $this->render('admin/admin_add_films.html.twig');
    }

    #[Route('/admin/movies', name: 'app_admin_movies')]
    #[IsGranted('ROLE_ADMIN')]
    public function movies(): Response
    {
        return $this->render('admin/admin_films.html.twig');
    }



    #[Route('/admin', name: 'app_admin_users')]
    #[IsGranted('ROLE_ADMIN')]
    public function users(): Response
    {
        return $this->render('admin/admin_users.html.twig');
    }
}