<?php

namespace App\Controller;

use App\Entity\AppUser;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    private $mailer;

    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        $user = new AppUser();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $user->setRoles(['ROLE_USER']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->sendHelloEmail($user);

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @param AppUser $user
     * @return bool|string
     */
    private function sendHelloEmail(AppUser $user) {

        $message = new \Swift_Message('Hello Email');

        $message->setFrom('send@example.com');
        $message->setTo('example@gmail.com');
        $message->setBody(
            $this->renderView(
                'emails/registration/register.html.twig',
                ['email' => $user->getEmail()]
            ),
            'text/html'
        );

        try {
            $response = $this->mailer->send($message);
        } catch(\Swift_TransportException $e) {
            return $e->getMessage();
        }

        return (bool) $response;
    }
}
