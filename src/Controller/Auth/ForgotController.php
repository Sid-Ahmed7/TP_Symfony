<?php

namespace App\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

use App\Repository\UserRepository;
use App\Entity\User;

class ForgotController extends AbstractController
{
    #[Route('/forgot', name: 'forgot_password')]
    public function forgot(Request $request, EntityManagerInterface $entityManager,UserRepository $userRepository, MailerInterface $mailer): Response
    {
       $emailUser = $request->get('_email');

       $user = $this->$userRepository->findOneBy(['email' => $emailUser]);
    // Check if the user exists 
        if(!$user) {
            $this->addFlash('error', 'User not found');
            return $this->redirectToRoute('app_login');
        }
       $resetToken = Uuid::v4();
       $user->setResetToken($resetToken);
       $this->$entityManager->flush();

       $this->sendResetPasswordEmail($mailer, $user);

    
        return $this->render('auth/forgot/forgot.html.twig');
    }

    private function sendResetPasswordEmail(MailerInterface $mailer, User $user): void
    {
        $resetUrl = $this->generateUrl('reset_password', ['token' => $user->getResetToken()], 0);
        $expirationDate = new \DateTime('+7 days');
        
        $email = (new TemplatedEmail())
            ->from('fabien@example.com')
            ->to($user->getEmail())
            ->subject('Reset your password')
            ->html(
                $this->renderView('email/reset.html.twig')
                )
            ->context([
                'user' => $user,
                'resetUrl' => $resetUrl,
                'expirationDate' => $expirationDate,
            ]);
        $mailer->send($email);
    }
}