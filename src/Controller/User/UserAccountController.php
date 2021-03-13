<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


use App\Form\UserType;


class UserAccountController extends AbstractController
{
    /**
     * @Route("/account", name="user_account")
     */
    public function index(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class,$user);

        return $this->render('front/user/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
