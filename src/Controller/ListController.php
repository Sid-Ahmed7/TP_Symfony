<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\PlaylistRepository;
use App\Repository\PlaylistSubscriptionRepository;

class ListController extends AbstractController
{
    #[Route('/list', name: 'app_list')]
    public function list(
        PlaylistRepository $playlistRepository,
        PlaylistSubscriptionRepository $subscription
    ): Response
    {
        $myPlaylists = $playlistRepository->findAll();
        $mySubscribedPlaylists = $playlistRepository->findAll();
        return $this->render('list/lists.html.twig', [
            'myPlaylists' => $myPlaylists,
             'mySubscribedPlaylists' => $mySubscribedPlaylists,
        ]);
    }
}