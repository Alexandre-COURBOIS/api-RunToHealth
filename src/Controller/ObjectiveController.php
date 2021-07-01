<?php

namespace App\Controller;

use App\Repository\ObjectiveAlcoholRepository;
use App\Repository\ObjectiveSmokerRepository;
use App\Repository\ObjectiveSportRepository;
use App\Repository\ObjectivesRepository;
use App\Repository\ObjectiveWeightRepository;
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
     * @param ObjectiveWeightRepository $objectiveWeightRepository
     * @param ObjectiveAlcoholRepository $objectiveAlcoholRepository
     * @param ObjectiveSmokerRepository $objectiveSmokerRepository
     * @param ObjectiveSportRepository $objectiveSportRepository
     * @return Response
     */
    public function index(UsersRepository $usersRepository,ObjectivesRepository $objectivesRepository,ObjectiveWeightRepository $objectiveWeightRepository
        ,ObjectiveAlcoholRepository $objectiveAlcoholRepository, ObjectiveSmokerRepository $objectiveSmokerRepository,ObjectiveSportRepository $objectiveSportRepository): Response
    {

        $user=$usersRepository->findOneBy(["email"=>"julien@gmail.com"]);

        $objectives=$objectivesRepository->findBy(["user"=>$user->getId()]);

        $arrayObjective=array();

        foreach ($objectives as $objective) {

            $valueObjective=null;

            $objectObjective = (object)['id' => '', 'type' => '', 'begin_at' => '', 'end_at' => '', 'success' => '','valueObjectif'];

            $objectObjective->id=$objective->getId();
            $objectObjective->type=$objective->getType();
            $objectObjective->begin_at=$objective->getBeginAt();
            $objectObjective->end_at=$objective->getEndAt();
            $objectObjective->success=$objective->getSucess();

            $weight = $objectiveWeightRepository->findBy(["objective" => $objective->getId()]);

            foreach ($weight as $weightObjective) {
                $valueObjective=$weightObjective->getNumber();
            }

            $alcohol = $objectiveAlcoholRepository->findBy(["objective" => $objective->getId()]);

            foreach ($alcohol as $alcoholObjective) {
                $valueObjective=$alcoholObjective->getDrink();
            }

            $smoker = $objectiveSmokerRepository->findBy(["objective" => $objective->getId()]);

            foreach ($smoker as $smokerObjective) {
                $valueObjective=$smokerObjective->getNumber();
            }

            $sport = $objectiveSportRepository->findBy(["objective" => $objective->getId()]);

            foreach ($sport as $sportObjective) {
                $valueObjective=$sportObjective->getTime();
            }
            $objectObjective->valueObjectif=$valueObjective;

            if(isset($valueObjective)){
                array_push($arrayObjective,$objectObjective);

            }

        }

        return new JsonResponse($arrayObjective);
    }
}
