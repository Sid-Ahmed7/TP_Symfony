<?php

namespace App\Controller\Media\Movie;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Movie;

class MovieController extends AbstractController
{
    #[Route(path: '/movie/{id}', name: 'page_detail_movie')]
    public function detailMovie(Movie $movie): Response
    {
        return $this->render( 'movie/detail.html.twig', [
            'movie' => $movie
        ]);
    }
}