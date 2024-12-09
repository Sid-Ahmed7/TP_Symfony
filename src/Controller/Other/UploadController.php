<?php

namespace App\Controller\Other;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Doctrine\ORM\EntityManagerInterface;

use App\Repository\UploadRepository;
use App\Entity\Upload;
use App\Service\FileUploader;

class UploadController extends AbstractController
{
    #[Route('/upload', name: 'app_upload')]
    #[IsGranted('ROLE_ADMIN')]
    public function upload(UploadRepository $uploadRepository): Response
    {
        $uploads = $uploadRepository->findAll();
        return $this->render('other/upload/upload.html.twig', [
            'uploads' => $uploads,
        ]);
    }

    #[Route(path: '/api/upload', name: 'api_upload')]
    public function uploadApi(
    Request $request,
    FileUploader $fileUploader,
    EntityManagerInterface $entityManager
    ): Response
    {
    /** @var UploadedFile[] $files */
    $files = $request->files->all()['files'];

    foreach ($files as $file) {
        $fileName = $fileUploader->upload($file);
        $upload = new Upload();
        $upload->setUploadedBy($this->getUser());
        $upload->setUrl($fileName);
        $entityManager->persist($upload);
    }

    $entityManager->flush();

    return $this->json([
        'message' => 'Upload successful!',
    ]);
    
    return $this->json([
        'message' => 'Upload failed!',
    ], Response::HTTP_BAD_REQUEST);
}
}