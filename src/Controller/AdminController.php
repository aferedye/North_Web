<?php

namespace App\Controller;

use App\Entity\Devis;
use App\Entity\User;
use App\Repository\DevisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class AdminController extends AbstractController
{
    


    /**
     * @Route("/admin", name="admin")
     * 
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/admin/devis", name="admin_devis")
     * 
     */
    public function devis()
    {
        $message = null;

        $em = $this->getDoctrine()->getRepository(Devis::class);
        $results = $em->findAll();

        return $this->render('admin/devis.html.twig', [
            'user' => $this->getUser(),
            'results' => $results,
            'message' => $message
        ]);
    }

    /**
     * @Route("/admin/devis/detail", name="admin_detail_devis")
     * 
     */
    public function devisDetail(Request $request) {

        $id = $request->get("iddevis");

        $em = $this->getDoctrine()->getRepository(Devis::class);
        $results = $em->findBy(array('id' => $id));

        return $this->render('admin/devisdetail.html.twig', [
            'user' => $this->getUser(),
            'results' => $results
        ]);
    }

    /**
     * @Route("/admin/devis/search/name", name="admin_devis_searchname")
     * 
     */
    public function searchName(Request $request)
    {
        $message = null;
        $results = null;

        $names = $request->get("Nom");

        /** @var DevisRepository $em */
        $em = $this->getDoctrine()->getRepository(Devis::class);

        if ($names != null) {
            $results = $em->searchName($names);
        } elseif($results == null) {
            $message = 'Aucun nom ne correspond dans la BDD';
        }

        return $this->render('admin/devis.html.twig', [
            'results' => $results,
            'user' => $this->getUser(),
            'message' => $message
        ]);

    }

    /**
     * @Route("/admin/devis/search/firstname", name="admin_devis_searchfirstname")
     * 
     */
    public function searchFirstName(Request $request)
    {
        $message = null;
        $results = null;
        $firstnames = $request->get("Prenom");

        /** @var DevisRepository $em */
        $em = $this->getDoctrine()->getRepository(Devis::class);

        if ($firstnames != null) {
            $results = $em->searchFirstname($firstnames);
        } elseif($results == null) {
            $message = 'Aucun prénom ne correspond dans la BDD';
        }

        return $this->render('admin/devis.html.twig', [
            'results' => $results,
            'user' => $this->getUser(),
            'message' => $message
        ]);

    }

    /**
     * @Route("/admin/devis/search/email", name="admin_devis_searchemail")
     * 
     */
    public function searchEmail(Request $request)
    {
        $message = null;
        $results = null;

        $email = $request->get("Email");

        /** @var DevisRepository $em */
        $em = $this->getDoctrine()->getRepository(Devis::class);

        if ($email != null) {
            $results = $em->searchEmail($email);
        } elseif($results == null) {
            $message = 'Aucun email ne correspond dans la BDD';
        }

        return $this->render('admin/devis.html.twig', [
            'results' => $results,
            'user' => $this->getUser(),
            'message' => $message
        ]);

    }

}
