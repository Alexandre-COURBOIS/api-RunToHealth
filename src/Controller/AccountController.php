<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/activating-account", name="activating-account")
     */
    public function accountActivation(Request $request, UsersRepository $usersRepository, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!empty($data)) {

            $user = $usersRepository->findOneBy(['resetToken' => $data['token']]);

            if ($user) {

                $user->setActive(true);
                $user->setActiveSince(new \DateTime());
                $user->setResetToken(null);

                $em->persist($user);
                $em->flush();

                return new JsonResponse("Votre compte est désormais bien activé !", Response::HTTP_OK);

            } else {
                return new JsonResponse("Requête invalide", Response::HTTP_BAD_REQUEST);
            }
        } else {
            return new JsonResponse("Merci de renseigner des données", Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/check-token", name="check-token"")
     */
    public function checkToken(Request $request, UsersRepository $usersRepository): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!empty($data)) {
            $user = $usersRepository->findOneBy(['resetToken' => $data['token']]);

            if ($user) {
                return new JsonResponse(Response::HTTP_OK);
            } else {
                return new JsonResponse(Response::HTTP_BAD_REQUEST);
            }
        } else {
            return new JsonResponse(Response::HTTP_BAD_REQUEST);
        }
    }
}
