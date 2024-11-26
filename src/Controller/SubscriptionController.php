<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SubscriptionController extends AbstractController
{
    #[Route('/subscriptions', name: 'app_subscriptions')]
    public function index(): Response
    {
        return $this->render('subscriptions/subscriptions.html.twig', [
            'controller_name' => 'AbonnementsController',
        ]);
    }
}