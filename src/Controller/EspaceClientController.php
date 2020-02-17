<?php

namespace App\Controller;

use App\Entity\Devis;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class EspaceClientController extends AbstractController
{
    /**
     * @Route("/espace/client", name="espace_client")
     */
    public function index()
    {
        return $this->render('espace_client/index.html.twig', [
            'user' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/espace/client/devis", name="espace_client_devis")
     */
    public function mesDevis()
    {
        $results = null;
        $message = null;
        $usermail = $this->getUser()->getEmail();

        $em = $this->getDoctrine()->getRepository(Devis::class);
        $results = $em->searchEmail($usermail);

        return $this->render('espace_client/devis.html.twig', [
            'user' => $this->getUser(),
            'results' => $results,
            'message' => $message
        ]);
    }

    /**
     * @Route("/espace/client/devis/detail", name="espace_client_devisdetail")
     */
    public function mesDevisDetail(Request $request)
    {
        $id = $request->get("iddevis");

        $em = $this->getDoctrine()->getRepository(Devis::class);
        $results = $em->findBy(array('id' => $id));
        $message = null;

        return $this->render('espace_client/devisdetail.html.twig', [
            'user' => $this->getUser(),
            'results' => $results,
            'message' => $message
        ]);
    }

    /**
     * @Route("/espace/client/profil", name="espace_client_profil")
     */
    public function monProfil()
    {
        $message = null;
        return $this->render('espace_client/devis.html.twig', [
            'user' => $this->getUser(),
            'message' => $message
        ]);
    }
}
