<?php

namespace App\Controller\Media;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;


class CategoryController extends AbstractController
{
    #[Route('/category/{id}', name: 'app_category')]
    public function category(
        string $id,
        CategoryRepository $categoryRepository,
    ): Response
    {
        dump($id);
        $category = $categoryRepository->find($id);

        return $this->render('category/category.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

    #[Route('/discover', name: 'app_category')]
    public function discover(EntityManagerInterface $entityManager, CategoryRepository $categoyRepository): Response
    {
        //Récup toutes les catégories
        $categories = $categoyRepository->findAll();

       
        return $this->render('category/category.html.twig', [
            'categories' => $categories,
        ]);
    }


}