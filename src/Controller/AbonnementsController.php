<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AbonnementsController extends AbstractController
{
    #[Route('/abonnements', name: 'app_abonnements')]
    public function index(): Response
    {
        return $this->render('abonnements/abonnements.html.twig', [
            'controller_name' => 'AbonnementsController',
        ]);
    }
}
