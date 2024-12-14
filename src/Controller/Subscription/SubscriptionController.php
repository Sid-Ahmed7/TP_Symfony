<?php

namespace App\Controller\Subscription;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


use App\Repository\SubscriptionRepository;

class SubscriptionController extends AbstractController
{
    #[Route('/subscriptions', name: 'app_subscriptions')]
    #[IsGranted('ROLE_USER')]
    public function subscription(
        SubscriptionRepository $subscriptionRepository
    ): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $currentSubscription = $user->getCurrentSubscription();
        $subscriptions = $subscriptionRepository->findAll();

        return $this->render('subscriptions/subscriptions.html.twig', [
            'currentSubscription' => $currentSubscription,
            'subscriptions' => $subscriptions
        ]);
    }
}