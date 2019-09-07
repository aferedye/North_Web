<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\DevisRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class MasterController extends AbstractController
{
    /**
     * @Route("/master", name="master")
     * @Security("is_granted('ROLE_MASTER')")
     */
    public function index()
    {
        return $this->render('master/index.html.twig', [
            'controller_name' => 'MasterController',
        ]);
    }

    /**
     * @Route("/master/user", name="master_user")
     * @Security("is_granted('ROLE_MASTER')")
     */
    public function user()
    {
        $message = null;

        $em = $this->getDoctrine()->getRepository(User::class);
        $results = $em->findAll();

        return $this->render('master/user.html.twig', [
            'user' => $this->getUser(),
            'results' => $results,
            'message' => $message

        ]);
    }

    /**
     * @Route("/master/user/search/name", name="master_user_searchlastname")
     * @Security("is_granted('ROLE_MASTER')")
     */
    public function searchuserlastname(Request $request)
    {
        $message = null;
        $results = null;

        $names = $request->get("Nom");

        /** @var DevisRepository $em */
        $em = $this->getDoctrine()->getRepository(User::class);

        if ($names != null) {
            $results = $em->searchName($names);
        } elseif($results == null) {
            $message = 'Aucun nom ne correspond dans la BDD';
        }

        return $this->render('master/user.html.twig', [
            'results' => $results,
            'user' => $this->getUser(),
            'message' => $message
        ]);

    }

    /**
     * @Route("/master/user/search/firstname", name="master_user_searchfirstname")
     * @Security("is_granted('ROLE_MASTER')")
     */
    public function searchuserFirstName(Request $request)
    {
        $message = null;
        $results = null;
        $firstnames = $request->get("Prenom");

        /** @var DevisRepository $em */
        $em = $this->getDoctrine()->getRepository(User::class);

        if ($firstnames != null) {
            $results = $em->searchFirstname($firstnames);
        } elseif($results == null) {
            $message = 'Aucun prénom ne correspond dans la BDD';
        }

        return $this->render('master/user.html.twig', [
            'results' => $results,
            'user' => $this->getUser(),
            'message' => $message
        ]);

    }

    /**
     * @Route("/master/user/search/email", name="master_user_searchemail")
     * @Security("is_granted('ROLE_MASTER')")
     */
    public function searchuserEmail(Request $request)
    {
        $message = null;
        $results = null;

        $email = $request->get("Email");

        /** @var DevisRepository $em */
        $em = $this->getDoctrine()->getRepository(User::class);

        if ($email != null) {
            $results = $em->searchEmail($email);
        } elseif($results == null) {
            $message = 'Aucun email ne correspond dans la BDD';
        }

        return $this->render('master/user.html.twig', [
            'results' => $results,
            'user' => $this->getUser(),
            'message' => $message
        ]);

    }

    /**
     * @Route("/master/user", name="master_user_role")
     * @Security("is_granted('ROLE_MASTER')")
     */
    public function changeRole(Request $request, ObjectManager $manager) {

        $message = null;

        $id = $request->get("iduser");

        $em = $this->getDoctrine()->getRepository(User::class);
        $results = $em->searchId($id);

        if ($results['0']->getRoles() != 'ROLE_ADMIN') {
            $result = $results['0']->setRoles('ROLE_ADMIN');
            $manager->persist($result);
            $manager->flush();
        }
        if ($results['0']->getRoles() != 'ROLE_USER') {
            $result = $results->setRoles('ROLE_USER');
            $manager->persist($result);
            $manager->flush();
        }


        return $this->render('master/user.html.twig', [
            'user' => $this->getUser(),
            'results' => $results,
            'message' => $message
        ]);
    }
}
