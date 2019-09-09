<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EspaceClientController extends AbstractController
{
    /**
     * @Route("/espace/client", name="espace_client")
     */
    public function index()
    {
        return $this->render('espace_client/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/espace/client/devis", name="espace_client_devis")
     */
    public function mesDevis()
    {
        return $this->render('espace_client/devis.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/espace/client/devis/detail", name="espace_client_devisdetail")
     */
    public function mesDevisDetail()
    {

        return $this->render('espace_client/devisdetail.html.twig', [
            'user' => $this->getUser()
        ]);
    }
}
