<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DetailserieController extends AbstractController
{
    #[Route('/detailserie', name: 'app_detailserie')]
    public function index(): Response
    {
        return $this->render('details/detail_serie.html.twig', [
            'controller_name' => 'DetailserieController',
        ]);
    }
}
