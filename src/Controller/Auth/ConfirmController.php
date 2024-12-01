<?php

namespace App\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConfirmController extends AbstractController
{
    #[Route('/confirm', name: 'app_confirm')]
    public function confirm(): Response
    {
        return $this->render('auth/confirm/confirm.html.twig');
    }
}