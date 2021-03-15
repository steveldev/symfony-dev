<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {

        $coverage = $projectRoot = $this->getParameter('kernel.project_dir');
        $coverage .= '\coverage\index.html';

        return $this->render('front/index.html.twig', [
            'coverage' => $coverage,
        ]);
    }
}
