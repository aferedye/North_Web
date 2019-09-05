<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
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
     */
    public function registration(Request $request, ObjectManager $manager,UserPasswordEncoderInterface $encoder) {

        $user = new User();
        $roles = 'ROLE_USER';
        $user->setRoles($roles);
        $date = new \DateTime('now');

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $user->setDateSubscribe($date);

            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            return $this->render('security/connexion.html.twig', [
                'user' => $this->getUser()
            ]);

        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/connexion", name="security_connexion")
     * @param Request $request
     * @param AuthenticationUtils $authUtils
     * @return Response
     */
    public function login(Request $request, AuthenticationUtils $authUtils) {

        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('security/connexion.html.twig',[
            'last_username' => $lastUsername,
            'error'         => $error,
            'user' => $this->getUser()
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
        TokenGeneratorInterface $tokenGenerator): Response

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
            } catch (\Exception $e) {
                $message = "Un problème est survenu pendant la génération du token";
                return $this->render('forgotten_password', [
                    'message' => $message
                ]);
            }

            $url = $this->generateUrl('app_reset_password', array('token' => $token, 'user' => $this->getUser()), UrlGeneratorInterface::ABSOLUTE_URL);

            $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
                ->setUsername('contact.northweb@gmail.com')
                ->setPassword('MafNorthW1')
            ;

            $mailer = new Swift_Mailer($transport);

            $mail = (new \Swift_Message('Mot de passe oublié'))
                ->setFrom('contact.northweb@gmail.com')
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
}
