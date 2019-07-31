<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{

    /**
     * @Route("/contact", name="contact_index")
     */

    public function index()
    {

        $em = $this->getDoctrine()->getRepository(Contact::class);
        $contacts = $em->findAll();

        return $this->render('contact/index.html.twig', [
            "controller_name" => 'ContactController'
        ]);
    }


    /**
     * @Route("/contact/datauser", name="contact_data")
     */
    public function datauser(Request $request){
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->add("add", SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $contact = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $this->addFlash("success", "Votre message a bien été envoyé :)");

            return $this->redirectToRoute("contact_index");
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);

    }





    public function mail(){



    }

}

