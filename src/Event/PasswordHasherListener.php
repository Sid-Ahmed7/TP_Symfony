<?php

namespace App\Event;

use Doctrine\Orm\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

#[AsEntityListener(event: Events::prePersist, entity: User::class)]
#[AsEntityListener(event: Events::preUpdate, entity: User::class)]
 
class PasswordHasherListeners 
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function prePersist(User $user)
    {
        $plainPassword = $user->getPlainPassword();
        if(!$plainPassword) {
            return;
        }

        $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPlainPassword());
        $user->setPassword($hashedPassword);
        $user->eraseCredentials();
    }
    

    public function preUpdate(User $user)
    {   
        $plainPassword = $user->getPlainPassword();
        if(!$plainPassword) {
            return;
        }

        $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPlainPassword());
        $user->setPassword($hashedPassword);
        $user->eraseCredentials();
        
    }
}



























