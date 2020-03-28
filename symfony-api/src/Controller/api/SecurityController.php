<?php

namespace App\Controller\api;

use App\Entity\AppUser;
use App\Repository\AppUserRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

class SecurityController extends AbstractFOSRestController
{
    private $mailer;

    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @Route("/api/login", name="api_login", methods={"POST"})
     */
    public function login()
    {
        return $this->json([
            'user' => $this->getUser() ? $this->getUser()->getId() : null
        ]);
    }

    /**
     * @Route("/api/signup", name="api_signup", methods={"POST"})
     * @throws \Exception
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, AppUserRepository $userRepository): JsonResponse
    {
        $user = new AppUser();

        $data = json_decode(
            $request->getContent(),
            true
        );

        $validator = Validation::createValidator();
        $constraint = new Assert\Collection([
            'email' => new Assert\Email(),
        ]);

        $violations = $validator->validate($data, $constraint);

        if ($violations->count() > 0) {
            return new JsonResponse(["error" => (string)$violations], 500);
        }

        $password =  $userRepository->randomPassword(10);
        $email = $data['email'];

        $user_exist = $userRepository->findByEmail($email);

        if ($user_exist) {
            return new JsonResponse(["error" => "Email ". $email ." already exist"], 500);
        }

        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $password
            )
        );

        $user->setEmail($email);

        $user->setRoles(['ROLE_USER']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $this->sendHelloEmail($user, [
            'password' => $password,
        ]);

        return new JsonResponse([
            "success" => $user->getUsername(). " has been registered! Your password send via email"
        ], 200);
    }

    /**
     * @param AppUser $user
     * @return bool|string
     */
    private function sendHelloEmail(AppUser $user, array $params) {

        $message = new \Swift_Message('Hello Email');

        $message->setFrom('send@example.com');
        $message->setTo('example@gmail.com');
        $message->setBody(
            $this->renderView(
                'emails/registration/register.html.twig',
                [
                    'email' => $user->getEmail(),
                    'params' => $params,
                    'login_url' => $this->getParameter('app.client_domain') . $this->getParameter('app.client_login_url'),
                ]
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
