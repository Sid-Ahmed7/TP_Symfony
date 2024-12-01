<?php

namespace App\Controller\Other;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UploadController extends AbstractController
{
    #[Route('/upload', name: 'app_upload')]
    public function upload(): Response
    {
        return $this->render('other/upload/upload.html.twig');
    }
}