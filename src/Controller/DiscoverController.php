<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class DiscoverController extends AbstractController
{
    #[Route('/discover', name: 'app_discover')]
    public function discover(EntityManagerInterface $entityManager, CategoryRepository $categoryRepository): Response
    {
        //Récup toutes les catégories
        $categories = $categoryRepository->findAll();

       
        return $this->render('discover/discover.html.twig', [
            'categories' => $categories
        ]);
    }
}