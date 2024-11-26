<?php

namespace App\Controller\Media\Movie;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\MovieRepository;

class MovieController extends AbstractController
{
    #[Route(path: '/movie', name: 'page_detail_movie')]
    public function detail(MovieRepository $movieRepository): Response
    {
        return $this->render( 'movie/detail.html.twig');
    }
}