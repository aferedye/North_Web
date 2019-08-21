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
     */
    public function index(Request $request)
    {
        $form = new Devis();

        $formul = $this->createFormBuilder($form)
            ->add('maquette',RangeType::class)
            ->add('lvlgraphisme', RangeType::class)
            ->add('nbrpage', RangeType::class)
            ->add('nbrlangue', RangeType::class)
            ->add('partieblog', CheckboxType::class)
            ->add('formulaireinscritdevis', RangeType::class)
            ->add('forum', CheckboxType::class)
            ->add('accesmembre', CheckboxType::class)
            ->add('gestionfichier', CheckboxType::class)
            ->add('cartedynamique', CheckboxType::class)
            ->add('integrvideo', CheckboxType::class)
            ->add('assistance', CheckboxType::class)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('email', TextType::class)
            ->add('telephone', TextType::class)
            ->add('valider', SubmitType::class)
            ->getForm();


        $formul->handleRequest($request);

        if ($formul->isSubmitted() && $formul->isValid()) {

            define('prixmaquette', 150);
            define('prixgraphisme', 50);
            define('prixpage', 20);
            define('prixlangue', 85);
            define('prixblog', 65);
            define('prixinscription', 60);
            define('prixforum', 80);
            define('prixmembre', 100);
            define('prixfichier', 70);
            define('prixcarte', 90);
            define('prixvideo', 45);
            define('prixassistance', 50);

            $formulaire = $formul->getData();

            $maquette = $formulaire->getMaquette();
            $lvlgraphisme = $formulaire->getLvlgraphisme();
            $nbrpage = $formulaire->getNbrPage();
            $nbrlangue = $formulaire->getNbrLangue();
            $partieblog = $formulaire->getPartieBlog();
            $forminscription = $formulaire->getFormulaireinscritdevis();
            $forum = $formulaire->getForum();
            $accesmembre = $formulaire->getAccesmembre();
            $gestionfichiers = $formulaire->getGestionfichier();
            $cartedynamique = $formulaire->getCartedynamique();
            $integrationvideo = $formulaire->getIntegrvideo();
            $assistance = $formulaire->getAssistance();
            $email = $formulaire->getEmail();
            $nom = $formulaire->getNom();
            $prenom = $formulaire->getPrenom();
            $tel = $formulaire->getTelephone();

            $totalmaquette = prixmaquette * $maquette;
            $totalgraphisme = prixgraphisme * $lvlgraphisme;
            $totalpage = prixpage * $nbrpage;
            $totallangue = prixlangue * $nbrlangue;
            $totalblog = prixblog * $partieblog;
            $totalinscription = prixinscription * $forminscription;
            $totalforum = prixforum * $forum;
            $totalmembre = prixmembre * $accesmembre;
            $totalfichier = prixfichier * $gestionfichiers;
            $totalcarte = prixcarte * $cartedynamique;
            $totalvideo = prixvideo * $integrationvideo;
            $totalassistance = prixassistance * $assistance;
            $totalHT = $totalmaquette +  $totalgraphisme + $totalpage + $totallangue + $totalblog + $totalinscription +
                $totalforum + $totalmembre + $totalfichier + $totalcarte + $totalvideo + $totalassistance;
            $totalTVA = $totalHT / 100 * 20;
            $totalTTC = $totalHT + $totalTVA;
            ob_start();
            ?>
            <html lang="fr">
<style>
    .txt-center { text-align: center; }
    .container { width:870px; margin: auto; }
    .border { border: 1px solid #D3D3D3; padding: 10px; }
    .border-r { border-right: 1px solid #D3D3D3; padding: 10px; }
    .floatl { float: left }
    .abs { position: absolute; top: 137px; left: 460px; }
    .30p { width: 30%; }
    .75p { width: 75%; }
    .50p { width: 49.5%; }
    .m-l { margin-left: 30px;}
    .m-t { margin-top: 25px; }
    table {
        width: 100%;
        color: #717375;
        line-height: 5mm;
        border-collapse: collapse;
        margin-top: 25px;
        margin-left: 30px;
    }
    h1{ padding-top: 10px; }

</style>
<body>
<div class="container">
<img src="C:\wamp64\www\NorthWeb\public\img\logo.png" alt="Logo North Web" width="100" class="floatl m-l">
<h1 class="txt-center">Devis</h1>
<p class="txt-center">Ce devis est à titre indicatif et ne constitue en aucun cas un acte de vente.<br/> Veuillez vous rapprochez de nos équipes afin d'obtenir un devis final.</p>
    <div class="border 30p m-l m-t">
        <strong>Détails de l'entreprise :</strong><br /><br />
        Société North Web<br />
        06.20.76.34.48<br />
        contact.northweb@gmail.com
    </div>
    <div class="border abs 30p m-t">
        <strong>Coordonnées du client :</strong><br /><br />
        <?php echo ucfirst($nom).' '.ucfirst($prenom) ?><br />
        <?php echo $tel ?><br />
        <?php echo $email ?>
    </div>

<table>
    <thead>
    <tr>
        <th class="50p border">Désignation</th>
        <th class="border">Quantité</th>
        <th class="border">Prix Unitaire</th>
        <th class="border">Prix Total</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td class="border">Maquette graphique</td>
        <td class="border"><?php echo $maquette; ?></td>
        <td class="border"><?php echo prixmaquette; ?></td>
        <td class="border"><?php echo $totalmaquette; ?></td>
    </tr>
    <tr>
        <td class="border">Niveau de graphisme</td>
        <td class="border"><?php echo $lvlgraphisme; ?></td>
        <td class="border"><?php echo prixgraphisme; ?></td>
        <td class="border"><?php echo $totalgraphisme; ?></td>
    </tr>
    <tr>
        <td class="border">Nombre de page(s)</td>
        <td class="border"><?php echo $nbrpage; ?></td>
        <td class="border"><?php echo prixpage; ?></td>
        <td class="border"><?php echo $totalpage; ?></td>
    </tr>
    <tr>
        <td class="border">Nombre de langue(s)</td>
        <td class="border"><?php echo $nbrlangue; ?></td>
        <td class="border"><?php echo prixlangue; ?></td>
        <td class="border"><?php echo $totallangue; ?></td>
    </tr>
    <tr>
        <td class="border">Partie actualité / blog</td>
        <td class="border"><?php echo $partieblog; ?></td>
        <td class="border"><?php echo prixblog; ?></td>
        <td class="border"><?php echo $totalblog; ?></td>
    </tr>
    <tr>
        <td class="border">Formulaire Inscription / Devis</td>
        <td class="border"><?php echo $forminscription; ?></td>
        <td class="border"><?php echo prixinscription; ?></td>
        <td class="border"><?php echo $totalinscription; ?></td>
    </tr>
    <tr>
        <td class="border">Forum de discussions</td>
        <td class="border"><?php echo $forum; ?></td>
        <td class="border"><?php echo prixforum; ?></td>
        <td class="border"><?php echo $totalforum; ?></td>
    </tr>
    <tr>
        <td class="border">Accès membres</td>
        <td class="border"><?php echo $accesmembre; ?></td>
        <td class="border"><?php echo prixmembre; ?></td>
        <td class="border"><?php echo $totalmembre; ?></td>
    </tr>
    <tr>
        <td class="border">Gestion des fichiers</td>
        <td class="border"><?php echo $gestionfichiers; ?></td>
        <td class="border"><?php echo prixfichier; ?></td>
        <td class="border"><?php echo $totalfichier; ?></td>
    </tr>
    <tr>
        <td class="border">Carte dynamique</td>
        <td class="border"><?php echo $cartedynamique; ?></td>
        <td class="border"><?php echo prixcarte; ?></td>
        <td class="border"><?php echo $totalcarte; ?></td>
    </tr>
    <tr>
        <td class="border">Intégration vidéo</td>
        <td class="border"><?php echo $integrationvideo; ?></td>
        <td class="border"><?php echo prixvideo; ?></td>
        <td class="border"><?php echo $totalvideo; ?></td>
    </tr>
    <tr>
        <td class="border">Offre d'assistance mensuelle</td>
        <td class="border"><?php echo $assistance; ?></td>
        <td class="border"><?php echo prixassistance; ?> / mois</td>
        <td class="border"><?php echo $totalassistance; ?></td>
    </tr>
    <tr>
        <td></td>
        <td class="border-r"></td>
        <td class="border"><strong>Prix H.T</strong></td>
        <td class="border"><?php echo $totalHT ?></td>
    </tr>
    <tr>
        <td></td>
        <td class="border-r"></td>
        <td class="border"><strong>TVA 20%</strong></td>
        <td class="border"><?php echo $totalTVA ?></td>
    </tr>
    <tr>
        <td></td>
        <td class="border-r"></td>
        <td class="border"><strong>Prix TTC</strong></td>
        <td class="border"><?php echo $totalTTC ?> €</td>
    </tr>
    </tbody>
</table>
</div>
</body>
</html>
            <?php
            $content = ob_get_clean();

            $pdf = new Html2Pdf("p","A4","fr");
            $pdf->writeHTML($content);
            $result = $pdf->output('devis.pdf', 'S');

            $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
                ->setUsername('contact.northweb@gmail.com')
                ->setPassword('MafNorthW1')
            ;

            $mailer = new Swift_Mailer($transport);
            $attachement = new Swift_Attachment($result, 'devis.pdf', 'application/pdf');

            $message = (new Swift_Message('Devis North Web'))
                ->setFrom('contact.northweb@gmail.com')
                ->setReplyTo([$email])
                ->setTo([$email])
                ->setBody("Bonjour,
            
             Voici le récapitulatif de votre devis, celui-ci est à titre indicatif et ne constitue pas un acte de vente.
             Si vous souhaitez travailler avec nous, veuillez contacter notre équipe afin d'établir le devis final.
                
             Merci pour votre compréhension,
             Nous vous souhaitons une agréable journée.
             L'équipe North Web.")
                ->attach($attachement)
            ;

            $mailer->send($message);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($form);
            $entityManager->flush();

            return $this->redirectToRoute('task_succes');
        }

        return $this->render('devis/index.html.twig', [
            'form_devis' => $formul->createView(),

        ]);
    }

    /**
     * @Route("/succes", name="task_succes")
     */
    public function succes() {

        $succes = 'Le devis vous a été envoyer par e-mail';
        return $this->render('succes/index.html.twig', [
            'succes' => $succes
        ]);
    }



}
