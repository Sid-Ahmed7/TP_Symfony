<?php

namespace App\Controller\List;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ListController extends AbstractController
{
    #[Route('/list', name: 'app_list')]
    #[IsGranted('ROLE_USER')]
    public function list(
    ): Response
    {
        $user = $this->getUser();

        // Check if the user is authenticated
        if(!$user) {
            return $this->redirectToRoute('app_login');
        }

        // Get the user's playlists and subscribed playlists 
        $playlists = $user->getPlaylists();
        $subscribedPlaylists = $user->getPlaylistSubscriptions();
        foreach ($playlists as $playlist) {
        $playlist->getPlaylistMedia();

        }
        return $this->render('list/lists.html.twig', [
            'playlists' => $playlists,
            'subscribedPlaylists' => $subscribedPlaylists
        ]);
    }
}
