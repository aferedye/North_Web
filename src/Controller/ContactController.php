<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends AbstractController
{

    /**
     * @Route("/contact", name="contact_index")
     * @param Request $request
     * @param \Swift_Mailer $mailer
     * @return Response
     */
    public function index(Request $request,
                          \Swift_Mailer $mailer
                           )
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);



        if($form->isSubmitted() && $form->isValid()){

            $message = (new \Swift_Message('Mail'))
                ->setFrom($utilisateur->getEmail())
                ->setTo('contact.northweb@gmail.com')
                ->setBody($utilisateur->getMessage(),
                    'text/plain');

            $mailer->send($message);
            $this->addFlash('success', 'Votre Message a bien été envoyé ! :) ');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()]);
    }

}

