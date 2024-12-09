<?php

namespace App\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;


use App\Repository\UserRepository;
use App\Entity\User;

class ResetController extends AbstractController
{
    #[Route('/reset/{token}', name: 'app_reset')]
    public function reset(string $token, Request $request, UserRepository $userRepository, EntityManagerinterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = $userRepository->findOneBy(['reset_token' => $token]);

        if (!$user) {
             $this->addFlash('error', 'Token invalide');
             return $this->redirectToRoute('app_forgot');
        }
        if ($request->isMethod('POST')) {
        $newPassword = $request->get('_password');
        $confirmPassword = $request->get('_confirmPassword');

        if ($newPassword !== $confirmPassword) {
            $this->addFlash('error', 'Les mots de passe ne correspondent pas');
            return $this->redirectToRoute('app_reset', ['token' => $token]);
        }

        $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
        $user->setPassword($hashedPassword);
        $user->setResetToken(null);
        $entityManager->persist($user);
        $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('auth/reset/reset.html.twig');
    }
}