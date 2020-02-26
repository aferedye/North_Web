<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\Handler\ContactHandler;
use Swift_SmtpTransport;
use Swift_Attachment;
use Swift_Mailer;
use Swift_Message;

class ContactController extends AbstractController
{

    /**
     * @Route("/contact", name="contact_index")
     */
    public function index(Request $request, \Swift_Mailer $mailer)
    {   
        $response = $request->request->get("prenom");
        $response1 = $request->request->get('nom');
        $response2 = $request->request->get("email");
        $response3 = $request->request->get("telephone");
        $response4 = $request->request->get("message");
        dump($response, $response1, $response2, $response3, $response4);
    
        if ($response != "" && $response1 != "" && $response2 != "" && $response3 != "" && $response4 != ""){

            $transport = (new Swift_SmtpTransport('smtp.sendgrid.net', 587))
                ->setUsername('app162060797@heroku.com')
                ->setPassword('5hbabazj0826');

            $mailer = new Swift_Mailer($transport);

            $message = (new \Swift_Message('Vous avez des messages'))
                ->setFrom($response2)
                ->setTo('app162060797@heroku.com')
                ->setBody(
                    "Message de : " . $response1 . " " . $response . "
                
                    " . $response4
                );

            $mailer->send($message);
            
            return $this->render('contact/index.html.twig', [    
                'user' => $this->getUser()
            ]);
        }

        return $this->render('contact/index.html.twig', [
                'user' => $this->getUser()
        ]);
    }
}

