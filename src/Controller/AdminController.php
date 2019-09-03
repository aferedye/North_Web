<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AdminController extends AbstractController
{
    private $security;

    /**
     * @Route("/admin", name="admin")
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function index()
    {


        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'user' => $this->getUser()
        ]);
    }
}
