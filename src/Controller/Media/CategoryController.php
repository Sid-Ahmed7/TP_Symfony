<?php

namespace App\Controller\Media;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategoryRepository;
use App\Repository\MovieRepository;
use App\Repository\MediaRepository;
USE App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;


class CategoryController extends AbstractController
{
  

    #[Route('/category/{id}', name: 'app_category')]
    public function category(
        Category $category,
        MediaRepository $mediaRepository,
    ): Response
    {
        $media = $mediaRepository->findByCategory($category);
        return $this->render('media/category/category.html.twig', [
            'category' => $category,
            'media' => $media
        ]);
    }
}