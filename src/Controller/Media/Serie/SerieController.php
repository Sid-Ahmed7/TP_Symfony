<?php

namespace App\Controller\Media\Serie;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SerieController extends AbstractController
{
    #[Route(path: '/serie', name: 'page_detail_serie')]
    public function detailSerie(): Response
    {
        return $this->render(view: 'serie/detail_serie.html.twig');
    }
}