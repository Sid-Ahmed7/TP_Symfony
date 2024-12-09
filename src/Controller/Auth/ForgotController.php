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

        if($request->isMethod('POST')) {
            $emailUser = $request->get('_email');
            if (empty($emailUser)) {
                $this->addFlash('error', 'Veuillez entrer un email valide.');
                return $this->redirectToRoute('forgot_password');
            }
            $user = $userRepository->findOneBy(['email' => $emailUser]);

            if(!$user) {
                $this->addFlash('error', 'Aucun utilisateur trouvé avec cette adresse email.');
                return $this->redirectToRoute('forgot_password');
            }

            // Generate a reset token
            $resetToken = Uuid::v4();
            $user->setResetToken($resetToken);
            $entityManager->flush();

            // Send the reset password email
            $this->sendResetPasswordEmail($mailer, $user);
        }
         
        return $this->render('auth/forgot/forgot.html.twig');
    }

    private function sendResetPasswordEmail(MailerInterface $mailer, User $user): void
    {
        $resetUrl = $this->generateUrl('app_reset', ['token' => $user->getResetToken()], 0);
        $expirationDate = new \DateTime('+7 days');
        
        $email = (new TemplatedEmail())
            ->from('messagerietest23@gmail')
            ->to($user->getEmail())
            ->subject('Reset your password')
            ->html(
                $this->renderView('email/reset.html.twig', [  
                    'user' => $user, 
                    'resetUrl' => $resetUrl,
                    'expirationDate' => $expirationDate,
                ])
            );
        $mailer->send($email);
        $this->redirectToRoute('app_login');
    }
}