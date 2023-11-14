<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(Security $security): Response
    {
        $user = $security->getUser();
        if (isset($user)){
            $roles = $user->getRoles();
            $user_email = $user->getUserIdentifier();
        }

        $is_companie = in_array("ROLE_COMPAINE",$roles);


        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'is_companie' => $is_companie,
            'user_email' => $user_email,
        ]);
    }
}
