<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;
use App\Repository\MovieRepository;
USE App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;


class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'app_category')]
    public function index(MovieRepository $movieRepository, CategoryRepository $categoryRepository): Response
    {
        $movies = $movieRepository->findAll();
        $categories = $categoryRepository->findAll();

        return $this->render('category/category.html.twig', [
            'movies' => $movies,
            'categories' => $categories
        ]);
    }
    

    #[Route('/categories/{id}', name: 'app_category_Id')]
    public function category(
        Category $category,
    ): Response
    {
        return $this->render('category/category.html.twig', [
            'category' => $category
        ]);
    }
}