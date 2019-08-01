<?php
/**
 * Created by PhpStorm.
 * User: Admin stagiaire
 * Date: 31/07/2019
 * Time: 16:49
 */

namespace App\Form\Handler;

use App\Entity\Contact;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Twig\Environment;

class ContactHandler
{

    /**
     * @var \Swift_Mailer
     */
    public function __construct()
    {

    }

   /* public function notify(Contact $contact){
        $message = (new \Swift_Message('Agence : North Web'))
            ->setFrom($contact->getEmail())
            ->setTo('contact.northweb@gmail.com')
            ->setReplyTo($contact->getEmail())
            ->setBody($this->renderer('emails/contact.html.twig'.[
                'contact' => $contact
                ]), 'text/html');

        $this->mailer->send();*/









  /*  public function succesform(){

       /* $message = \Swift_Message::class()
            ->setContentType('text/html')
            ->setSubject($data['Hello'])
            ->setFrom($data['contact.northweb@gmail.com'])
            ->setTo('contact.northweb@gmail.com')
            ->setBody($data['test number 1']);

        $this->mailer->send($message);

        $this->get('session')->setFlash('notice', 'Merci de nous avoir contacté, nous répondrons à vos questions dans les plus brefs délais.');
*/


}