<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserAccountController extends AbstractController
{
    /**
     * @Route("/account", name="user_account")
     */
    public function index(): Response
    {
        return $this->render('front/user/index.html.twig', [
        ]);
    }
}
