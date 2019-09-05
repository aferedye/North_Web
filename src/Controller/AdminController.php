<?php

namespace App\Controller;

use App\Entity\Devis;
use App\Repository\DevisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/admin/devis", name="admin_devis")
     * @Security("is_granted('ROLE_ADMIN')")
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
     * @Security("is_granted('ROLE_ADMIN')")
     */
    public function devisdetail() {

        return $this->render('admin/devisdetail.html.twig', [
            'user' => $this->getUser(),
        ]);
    }


    /**
     * @Route("/admin/devis/search/name", name="admin_devis_searchname")
     * @Security("is_granted('ROLE_ADMIN')")
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
     * @Security("is_granted('ROLE_ADMIN')")
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
     * @Security("is_granted('ROLE_ADMIN')")
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
