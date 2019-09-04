<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Handler\ContactHandler;

class ContactController extends AbstractController
{

    /**
     * @Route("/contact", name="contact_index")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {

     /*   $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        $this->addFlash('info', 'Test number 1' );

        if ($form->isSubmitted() && $form->isValid()){
            $contactFormData = $form->getData();

            $message = (new \Swift_Message('Vous avez des messages'))
                ->setFrom($contactFormData['from'])
                ->setTo('contact.northweb@gmail.com')
                ->setBody(
                    $contactFormData['message'],
                    'text/plain'
                );

            $mailer->send($message);
            $this->addFlash('succes', 'Message envoyé !');
            return $this->redirectToRoute('contact');

        }

        return $this->render('contact/index.html.twig', [
                'our_form' => $form->createView(),
        ]); */


        $response = $request->request->get("prenom");
        $response1 = $request->request->get('nom');
        $response2 = $request->request->get("email");
        $response3 = $request->request->get("telephone");
        $response4 = $request->request->get("message");

        dump($response, $response1, $response2, $response3, $response4);



        //return $this->redirectToRoute("contact_index");
        return $this->render('contact/index.html.twig', [
            "controller_name" => 'ContactController',
            'user' => $this->getUser()
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $mailer->send($message);
            $this->addFlash("success", "Votre message a bien été envoyé :)");
            return $this->redirectToRoute('index.html.twig');
        }




    }



    protected function addFlash(string $type, string $message)
    {
    }


}

