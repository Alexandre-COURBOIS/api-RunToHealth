<?php

namespace App\Controller;

use App\Repository\ObjectivesRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ObjectiveController extends AbstractController
{
    /**
     * @Route("/objective", name="objective")
     * @param UsersRepository $usersRepository
     * @param ObjectivesRepository $objectivesRepository
     * @return Response
     */
    public function index(UsersRepository $usersRepository,ObjectivesRepository $objectivesRepository): Response
    {

        $user=$usersRepository->findOneBy(["email"=>"julien@gmail.com"]);

        $objective=$objectivesRepository->findBy(["user"=>$user->getId()]);

        foreach ($objective as $test) {
            var_dump($test->getType());

        }

        return new JsonResponse($user->getId());
    }
}
