<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Exception;
use Swift_Mailer;
use Swift_SmtpTransport;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_registration")
     * @param Request $request
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @param TokenGeneratorInterface $tokenGenerator
     * @param Swift_Mailer $mailer
     * @return Response
     * @throws Exception
     */
    public function registration(Request $request, ObjectManager $manager,UserPasswordEncoderInterface $encoder,
                                 TokenGeneratorInterface $tokenGenerator,\Swift_Mailer $mailer) {

        $lastUsername = null;
        $error = null;
        $roles = 'ROLE_USER';
        $enabled = 0;

        $user = new User();
        $date = new \DateTime('now', new \DateTimeZone('europe/paris'));

        $user->setRoles($roles);
        $user->setEnabled($enabled);
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $user->setDateSubscribe($date);
            $token = $tokenGenerator->generateToken();

            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setConfirmationToken($token);
            $user->setPassword($hash);

            $lastUsername = $user->getEmail();

            $manager->persist($user);
            $manager->flush();

            $url = $this->generateUrl('confirm_account', array('token' => $token, 'user' => $this->getUser()), UrlGeneratorInterface::ABSOLUTE_URL);

            $mail = (new \Swift_Message('Confirmez votre e-mail'))
                ->setFrom('testphp59150@gmail.com')
                ->setTo($lastUsername)
                ->setBody(
                    "Bonjour, 
                     Confirmez votre compte en cliquant sur ce lien : " . $url,
                    'text/html'
                );

            $mailer->send($mail);



            return $this->render('security/connexion.html.twig', [
                'last_username' => $lastUsername,
                'error'         => $error,
                'user' => $this->getUser()
            ]);

        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/account/confirm/{token}", name="confirm_account")
     * @param $token
     * @return Response
     */
    public function confirmAccount(string $token): Response
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository(User::class)->findOneBy(array('ConfirmationToken' => $token));
        /* @var $user User */

        if ($user === null) {
            $message = "Token inconnu";
            return $this->redirectToRoute('accueil', [
                'message' => $message
            ]);
        }

        $user->setConfirmationToken(null);
        $user->setEnabled(true);
        $em->persist($user);
        $em->flush();
            return $this->redirectToRoute('security_connexion');
    }

    /**
     * @Route("/connexion", name="security_connexion")
     * @param Request $request
     * @param AuthenticationUtils $authUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authUtils) {
        $lastUsername = null;

        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('security/connexion.html.twig',[
            'last_username' => $lastUsername,
            'error'         => $error,
            'user' => $this->getUser(),
        ]);
    }


    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout() {
        return $this->render('accueil/index.html.twig');
    }

    /**
     * @Route("/forgottenPassword", name="forgotten_password")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param \Swift_Mailer $mailer
     * @param TokenGeneratorInterface $tokenGenerator
     * @return Response
     */
    public function forgottenPassword(
        Request $request,
        UserPasswordEncoderInterface $encoder,
        TokenGeneratorInterface $tokenGenerator,\Swift_Mailer $mailer): Response

    {
        $message = null;

        if ($request->isMethod('POST')) {


            $email = $request->request->get('email');

            $entityManager = $this->getDoctrine()->getManager();
            $user = $entityManager->getRepository(User::class)->findOneBy(array('email' => $email));
            /* @var $user User */



            if ($user === null) {
                $message = "L'email saisi n'existe pas dans notre base";
                return $this->render('security/forgotten_password.html.twig', [
                    'user' => $this->getUser(),
                    'message' => $message
                ]);
            }

            $token = $tokenGenerator->generateToken();

            try{
                $user->setResetToken($token);
                $entityManager->flush();
            } catch (Exception $e) {
                $message = "Un problème est survenu pendant la génération du token";
                return $this->render('forgotten_password', [
                    'message' => $message
                ]);
            }

            $url = $this->generateUrl('app_reset_password', array('token' => $token, 'user' => $this->getUser()), UrlGeneratorInterface::ABSOLUTE_URL);

            $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
                ->setUsername('testphp59150@gmail.com')
                ->setPassword('testphp59!');

            $mailer = new Swift_Mailer($transport);

            $mail = (new \Swift_Message('Mot de passe oublié'))
                ->setFrom('testphp59@gmail.com')
                ->setTo([$email])
                ->setBody(
                    "Bonjour, 
                     Vous pouvez choisir votre nouveau mot de passe en cliquant sur ce lien : " . $url,
                    'text/html'
                );

            $mailer->send($mail);

            return $this->redirectToRoute('accueil');
        }

        return $this->render('security/forgotten_password.html.twig',[
            'user' => $this->getUser(),
            'message' => $message
        ]);
    }

    /**
     * @Route("/reset_password/{token}", name="app_reset_password")
     * @param Request $request
     * @param string $token
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {

        if ($request->isMethod('POST')) {
            $entityManager = $this->getDoctrine()->getManager();

            $user = $entityManager->getRepository(User::class)->findOneBy(array('resetToken' => $token));
            /* @var $user User */

            if ($user === null) {
                $message = "Token inconnu";
                return $this->redirectToRoute('accueil', [
                    'message' => $message
                ]);
            }

            $user->setResetToken(null);
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $entityManager->flush();

            $message = "Le mot de passe à été mis a jour";

            return $this->redirectToRoute('security_connexion', [
                'message' => $message
            ]);

        }else {

            return $this->render('security/reset_password.html.twig', [
                'token' => $token,
                'user' => $this->getUser()
            ]);
        }

    }
    /**
     * @return string
     * @throws \Exception
     */
    private function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
}
