<?php

namespace App\Controller\List;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\PlaylistRepository;
use App\Repository\PlaylistSubscriptionRepository;
use App\Entity\Playlist;
use App\Entity\User;
class ListController extends AbstractController
{
    #[Route('/list', name: 'app_list')]
    public function list(
        PlaylistRepository $playlistRepository,
        PlaylistSubscriptionRepository $subscription
    ): Response
    {
        $user = $this->getUser();

        // Check if the user is authenticated
        if(!$user) {
            return $this->redirectToRoute('app_home');
        }

        // Get the user's playlists and subscribed playlists 
        $myPlaylists = $user->getPlaylists();
        $mySubscribedPlaylists = $user->getPlaylistSubscriptions();
        return $this->render('list/lists.html.twig', [
            'myPlaylists' => $myPlaylists,
             'mySubscribedPlaylists' => $mySubscribedPlaylists,
        ]);
    }
}