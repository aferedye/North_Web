<?php

namespace App\Controller;

use App\Entity\Devis;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;
use Swift_Attachment;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DevisController
 * @package App\Controller
 * @Route("/devis")
 */
class DevisController extends AbstractController
{
    /**
     * @Route("/", name="devis")
     * @param Request $request
     * @return RedirectResponse|Response
     * @throws Html2PdfException
     * @throws \Exception
     */
    public function index(Request $request)
    {
        $form = new Devis();

        $formul = $this->createFormBuilder($form)
            ->add('maquette', RangeType::class)
            ->add('lvlgraphisme', RangeType::class)
            ->add('partieblog', CheckboxType::class)
            ->add('forum', CheckboxType::class)
            ->add('accesmembre', CheckboxType::class)
            ->add('gestionfichier', CheckboxType::class)
            ->add('cartedynamique', CheckboxType::class)
            ->add('integrvideo', CheckboxType::class)
            ->add('assistance', CheckboxType::class)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('nomprojet', TextType::class)
            ->add('email', TextType::class)
            ->add('telephone', TextType::class)
            ->add('valider', SubmitType::class)
            ->getForm();

        $formul->handleRequest($request);

        if ($formul->isSubmitted() && $formul->isValid()) {

            $date = new \DateTime('now', new \DateTimeZone('europe/paris'));
            $formulaire = $formul->getData();
            $nbrlang = $request->request->get('a');
            $nbrpage = $request->request->get('b');
            $nbrdevis = $request->request->get('c');
            $email = $formulaire->getEmail();

            $content = $this->renderView('devis/pdf.html.twig', [
                'maquette' => $maquette = $formulaire->getMaquette(),
                'lvlgraphisme' => $formulaire->getLvlgraphisme(),
                'nbrpage' => $nbrpage,
                'nbrlangue' => $nbrlang,
                'partieblog' => $formulaire->getPartieBlog(),
                'forminscription' => $nbrdevis,
                'forum' => $formulaire->getForum(),
                'accesmembre' => $formulaire->getAccesmembre(),
                'gestionfichiers' => $formulaire->getGestionfichier(),
                'cartedynamique' => $formulaire->getCartedynamique(),
                'integrationvideo' => $formulaire->getIntegrvideo(),
                'assistance' => $formulaire->getAssistance(),
                'email' => $formulaire->getEmail(),
                'nom' => $formulaire->getNom(),
                'prenom' => $formulaire->getPrenom(),
                'tel' => $formulaire->getTelephone(),
            ]);

            $pdf = new Html2Pdf("p", "A4", "fr");
            $pdf->writeHTML($content);
            $result = $pdf->output('devis.pdf', 'S');

            /* $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
                ->setUsername('testphp59150@gmail.com')
                ->setPassword('testphp59!');

            $mailer = new Swift_Mailer($transport);
            $attachement = new Swift_Attachment($result, 'devis.pdf', 'application/pdf');

            $message = (new Swift_Message('Devis North Web'))
                ->setFrom('testphp59150@gmail.com')
                ->setReplyTo([$email])
                ->setTo([$email])
                ->setBody("Bonjour,
            
             Voici le récapitulatif de votre devis, celui-ci est à titre indicatif et ne constitue pas un acte de vente.
             Si vous souhaitez travailler avec nous, veuillez contacter notre équipe afin d'établir le devis final.
                
             Merci pour votre compréhension,
             Nous vous souhaitons une agréable journée.
             L'équipe North Web.")
                ->attach($attachement);

            
            $this->getMailer->send($message); */
            
            $HT = $this->calculHT($formulaire, $nbrpage, $nbrlang, $nbrdevis);


            /*$email = (new Email())
            ->from('hello@example.com')
            ->to($email)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!')
            ->html('<p>See Twig integration for better HTML integration!</p>');

            $mailer->send($email);*/

            $form->setHorstaxe($HT);
            $form->setDate($date);
            $form->setNbrpage($nbrpage);
            $form->setNbrlangue($nbrlang);
            $form->setFormulaireinscritdevis($nbrdevis);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($form);
            $entityManager->flush();


            //return $this->redirectToRoute('task_succes', array(
              //'ttc' => $ttc
           // ));
        }

        return $this->render('devis/index.html.twig', [
            'form_devis' => $formul->createView(),
            'user' => $this->getUser()
        ]);
    }

    const prixmaquette = 150;
    const prixgraphisme = 150;
    const prixpage = 150;
    const prixblog = 150;
    const prixinscription = 150;
    const prixforum = 150;
    const prixmembre = 150;
    const prixfichier = 150;
    const prixcarte = 150;
    const prixvideo = 150;
    const prixlangue = 150;
    const prixassistance = 150;

    public function calculHT($formulaire, $nbrpage, $nbrlang, $nbrdevis)
    {
        $totalmaquette = $formulaire->getMaquette() * self::prixmaquette;
        $totalgraphisme = $formulaire->getLvlgraphisme() * self::prixgraphisme;
        $totalpage = $nbrpage * self::prixpage;
        $totalblog = $formulaire->getPartieBlog() * self::prixblog;
        $totalinscription = $nbrdevis * self::prixinscription;
        $totalforum = $formulaire->getForum() * self::prixforum;
        $totalmembre = $formulaire->getAccesmembre() * self::prixmembre;
        $totalfichier = $formulaire->getGestionfichier() * self::prixfichier;
        $totalcarte = $formulaire->getCartedynamique() * self::prixcarte;
        $totalvideo = $formulaire->getIntegrvideo() * self::prixvideo;
        $totallangue = $nbrlang * self::prixlangue;
        $totalassistance = $formulaire->getAssistance() * self::prixassistance;
        $HT = $totalmaquette + $totalgraphisme + $totalpage + $totalblog + $totalinscription + $totalforum + $totalmembre +
            $totalfichier + $totalcarte + $totalvideo + $totallangue + $totalassistance;
        return $HT;
    }

    /**
     * @Route("/succes", name="task_succes")
     */
    public function succes()
    {

        $succes = 'Le devis vous a été envoyer par e-mail';
        return $this->render('succes/index.html.twig', [
            'succes' => $succes,
            'user' => $this->getUser()
        ]);
    }


}
