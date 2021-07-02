<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    /**
     * @Route("/api/active-account", name="active_account", methods={"POST"})
     * @throws \Exception
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function activeAccount(Request $request, UsersRepository $usersRepository, MailerInterface $mailer, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        $user = $usersRepository->findOneBy(['email' => $data['email']]);

        $user->setResetToken(rtrim(strtr(base64_encode(random_bytes(64)), '+/', '-_'), '='));

        $em->persist($user);
        $em->flush();

        $email = (new TemplatedEmail())
            ->from('support.web@runtohealth.com')
            ->to($user->getEmail())
            ->subject("Cliquer pour activer votre compte")
            ->htmlTemplate('email/account_activation.html.twig')
            ->context([
                'user' => $user
            ]);

        $mailer->send($email);

        return new JsonResponse('Un email vient de vous être envoyé pour activer votre compte', Response::HTTP_OK);

    }
}
