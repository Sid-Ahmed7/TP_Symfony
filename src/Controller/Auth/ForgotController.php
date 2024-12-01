<?php

namespace App\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ForgotController extends AbstractController
{
    #[Route('/forgot', name: 'app_forgot')]
    public function forgot(): Response
    {
        return $this->render('auth/forgot/forgot.html.twig');
    }
}