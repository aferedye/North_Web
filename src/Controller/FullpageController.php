<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FullpageController extends AbstractController
{
    /**
     * @Route("/fullpage", name="fullpage")
     */
    public function index()
    {
        return $this->render('fullpage/index.html.twig', [
            'controller_name' => 'FullpageController',
        ]);
    }
}
