<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ResetController extends AbstractController
{
    #[Route('/reset', name: 'app_reset')]
    public function index(): Response
    {
        return $this->render('reset/reset.html.twig', [
            'controller_name' => 'ResetController',
        ]);
    }
}
