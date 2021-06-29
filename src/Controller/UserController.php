<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use App\Service\SecurityFunctions;
use App\Service\SerializerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UserController extends AbstractController
{

    private SerializerService $serializerService;

    public function __construct(SerializerService $serializer)
    {
        $this->serializerService = $serializer;
    }

    /**
     * @Route("/api/get/user", name="get_user", methods={"POST"})
     * @param UsersRepository $usersRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function getUserInformations(UsersRepository $usersRepository, Request $request): JsonResponse
    {
        $datas = json_decode($request->getContent(), true);

        if ($datas !== null && $datas) {

            $email = $datas['email'];

            $user = $usersRepository->findOneBy(['email' => $email]);

            $jsonContent = $this->serializerService->RelationSerializerGroups($user, 'json','users');

            return JsonResponse::fromJsonString($jsonContent);

        } else {
            return new JsonResponse("Please send a valid data", Response::HTTP_BAD_REQUEST);
        }
    }
}
