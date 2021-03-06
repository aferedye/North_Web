<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Handler\ContactHandler;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactController extends AbstractController
{

    /**
     * @Route("/contact", name="contact_index")
     */
    public function index(Request $request, MailerInterface $mailer)
    {   

        $email = (new Email())
            ->from('hello@example.com')
            ->to('aferedye@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

        $mailer->send($email);


        $response = $request->request->get("prenom");
        $response1 = $request->request->get('nom');
        $response2 = $request->request->get("email");
        $response3 = $request->request->get("telephone");
        $response4 = $request->request->get("message");
    
        if ($response != "" && $response1 != "" && $response2 != "" && $response3 != "" && $response4 != ""){

            /*$message = (new \Swift_Message('Vous avez des messages'))
                ->setFrom($response2)
                ->setTo('app162060797@heroku.com')
                ->setBody(
                    "Message de : " . $response1 . " " . $response . "
                
                    " . $response4
                );

            $mailer->send($message);*/
            
            return $this->render('contact/index.html.twig', [    
                'user' => $this->getUser()
            ]);
        }

        return $this->render('contact/index.html.twig', [
                'user' => $this->getUser()
        ]);
    }
}

