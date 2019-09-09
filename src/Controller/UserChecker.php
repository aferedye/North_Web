<?php
/**
 * Created by PhpStorm.
 * User: Admin stagiaire
 * Date: 09/09/2019
 * Time: 14:39
 */

namespace App\Controller;


use App\Exception\AccountDeletedException;
use App\Controller\SecurityController as AppUser;
use Symfony\Component\Security\Core\Exception\AccountExpiredException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;


class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            return;
        }

        // user is deleted, show a generic Account Not Found message.
        if ($user->isDeleted()) {
            throw new AccountDeletedException();
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof AppUser) {
            if ($user->getEnabled() === null) {
                $message = "Votre compte est inactif";
                return $message;}
        }

    }
}