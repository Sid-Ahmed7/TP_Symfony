<?php

namespace App\Controller\Media;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;

class DiscoverController extends AbstractController
{
    #[Route('/discover', name: 'app_discover')]
    public function discover(EntityManagerInterface $entityManager, CategoryRepository $categoryRepository, MediaRepository $mediaRepository): Response
    {
        //Ajouter les recoomendations en fonction de la note de la série 
        $recommandationsSerie = $mediaRepository->findRecommandationBySerieAndScore(3);
        //Ajouter les recoomendations en fonction de la note de la série ou film
        $recommandationsMovie = $mediaRepository->findRecommandationByMovieAndScore(3);
        //Récup toutes les catégories
        $categories = $categoryRepository->findAll();


        return $this->render('media/discover/discover.html.twig', [
            'categories' => $categories,
            'recommandationsSerie' => $recommandationsSerie,
            'recommandationsMovie' => $recommandationsMovie
        ]);
    }
}
