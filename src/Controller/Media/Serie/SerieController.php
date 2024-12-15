<?php

namespace App\Controller\Media\Serie;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\MediaRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Serie;

class SerieController extends AbstractController
{
    #[Route(path: '/serie/{id}', name: 'page_detail_serie')]
    public function detailSerie(Serie $serie): Response
    {
        return $this->render('media/serie/detail_serie.html.twig', [
            'serie' => $serie
        ]);
    }

    #[Route(path: '/series', name: 'page_series')]
    public function showAllSerie(MediaRepository $mediaRepository): Response
    {
        $series = $mediaRepository->findAllSeries();

        return $this->render('media/display_media.html.twig', [
            'series' => $series
        ]);
    }


}