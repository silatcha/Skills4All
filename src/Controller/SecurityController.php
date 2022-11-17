<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'security.login')]
    public function login(AuthenticationUtils $authentication)
    {
        $error= $authentication->getLastAuthenticationError();
        $lastUsername = $authentication->getLastUsername();


return $this->render('security/login.html.twig', [
    'last_username' => $lastUsername,
    'error' => $error
]);


    }
}
