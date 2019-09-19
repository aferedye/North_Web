<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class QuiSommesNousController extends AbstractController
{
    /**
     * @Route("/presentation", name="presentation")
     */
    public function index()
    {
        return $this->render('qui_sommes_nous/index.html.twig', [
            'controller_name' => 'QuiSommesNousController',
            'user' => $this->getUser()
        ]);
    }
}
