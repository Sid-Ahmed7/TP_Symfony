<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ForgotController extends AbstractController
{
    #[Route('/forgot', name: 'app_forgot')]
    public function index(): Response
    {
        return $this->render('forgot/forgot.html.twig', [
            'controller_name' => 'ForgotController',
        ]);
    }
}
