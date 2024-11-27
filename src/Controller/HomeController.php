<?php

namespace App\Controller;

use App\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index( MediaRepository $mediaRepository): Response
    {
        $medias = $mediaRepository->findTendances(5);
        return $this->render('index.html.twig', [
            'medias' => $medias
        ]);
    }
}