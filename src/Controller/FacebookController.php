<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FacebookController extends AbstractController
{
    /**
     * @Route("/facebook", name="facebook")
     */
    public function index(): Response
    {
        return $this->render('facebook/index.html.twig', [
            'controller_name' => 'FacebookController',
        ]);
    }
}
