<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConfirmController extends AbstractController
{
    #[Route('/confirm', name: 'app_confirm')]
    public function index(): Response
    {
        return $this->render('confirm/confirm.html.twig', [
            'controller_name' => 'ConfirmController',
        ]);
    }
}
