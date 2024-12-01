<?php

namespace App\Controller\Subscription;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\SubscriptionRepository;

class SubscriptionController extends AbstractController
{
    #[Route('/subscriptions', name: 'app_subscriptions')]
    public function subscription(
        SubscriptionRepository $subscriptionRepository
    ): Response
    {
        $subscriptions = $subscriptionRepository->findAll();

        return $this->render('subscriptions/subscriptions.html.twig', [
            'subscriptions' => $subscriptions
        ]);
    }
}