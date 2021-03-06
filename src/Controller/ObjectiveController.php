<?php

namespace App\Controller;

use App\Entity\Objectives;
use App\Repository\ObjectiveAlcoholRepository;
use App\Repository\ObjectiveSmokerRepository;
use App\Repository\ObjectiveSportRepository;
use App\Repository\ObjectivesRepository;
use App\Repository\ObjectiveWeightRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ObjectiveController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->manager = $entityManager;
    }

    /**
     * @Route("api/get-available-objectif", name="get_availables_objective", methods={"GET"})
     * @param ObjectivesRepository $objectivesRepository
     * @param ObjectiveWeightRepository $objectiveWeightRepository
     * @param ObjectiveAlcoholRepository $objectiveAlcoholRepository
     * @param ObjectiveSmokerRepository $objectiveSmokerRepository
     * @param ObjectiveSportRepository $objectiveSportRepository
     * @return JsonResponse
     */
    public function index(ObjectivesRepository $objectivesRepository, ObjectiveWeightRepository $objectiveWeightRepository,
                          ObjectiveAlcoholRepository $objectiveAlcoholRepository, ObjectiveSmokerRepository $objectiveSmokerRepository,
                          ObjectiveSportRepository $objectiveSportRepository): JsonResponse
    {

        $user = $this->getUser();

        $objectives = $objectivesRepository->findBy(["user" => $user->getId()]);

        $arrayObjective = array();

        foreach ($objectives as $objective) {

            $valueObjective = null;

            $objectObjective = (object)['id' => '', 'type' => '', 'begin_at' => '', 'end_at' => '', 'success' => '', 'valueObjectif'];

            $objectObjective->id = $objective->getId();
            $objectObjective->type = $objective->getType();
            $objectObjective->begin_at = $objective->getBeginAt();
            $objectObjective->end_at = $objective->getEndAt();
            $objectObjective->success = $objective->getSucess();

            $weight = $objectiveWeightRepository->findBy(["objective" => $objective->getId()]);

            foreach ($weight as $weightObjective) {
                $valueObjective = $weightObjective->getNumber();
            }

            $alcohol = $objectiveAlcoholRepository->findBy(["objective" => $objective->getId()]);

            foreach ($alcohol as $alcoholObjective) {
                $valueObjective = $alcoholObjective->getDrink();
            }

            $smoker = $objectiveSmokerRepository->findBy(["objective" => $objective->getId()]);

            foreach ($smoker as $smokerObjective) {
                $valueObjective = $smokerObjective->getNumber();
            }

            $sport = $objectiveSportRepository->findBy(["objective" => $objective->getId()]);

            foreach ($sport as $sportObjective) {
                $valueObjective = $sportObjective->getTime();
            }
            $objectObjective->valueObjectif = $valueObjective;

            if (isset($valueObjective)) {
                array_push($arrayObjective, $objectObjective);

            }

        }

        return new JsonResponse($arrayObjective, Response::HTTP_OK);
    }

    /**
     * @Route("/api/get-objective-id", name="get_objective_by_id")
     * @param Request $request
     * @param ObjectivesRepository $objectivesRepository
     * @param ObjectiveWeightRepository $objectiveWeightRepository
     * @param ObjectiveAlcoholRepository $objectiveAlcoholRepository
     * @param ObjectiveSmokerRepository $objectiveSmokerRepository
     * @param ObjectiveSportRepository $objectiveSportRepository
     * @return Response
     */
    public function search_objective(Request $request, ObjectivesRepository $objectivesRepository, ObjectiveWeightRepository $objectiveWeightRepository
        , ObjectiveAlcoholRepository $objectiveAlcoholRepository, ObjectiveSmokerRepository $objectiveSmokerRepository, ObjectiveSportRepository $objectiveSportRepository): Response
    {

        $data = json_decode($request->getContent(), true);

        $objectives = $objectivesRepository->findBy(["id" => $data]);

        $arrayObjective = array();

        foreach ($objectives as $objective) {

            $valueObjective = null;

            $objectObjective = (object)['id' => '', 'type' => '', 'begin_at' => '', 'end_at' => '', 'success' => '', 'valueObjectif'];

            $objectObjective->id = $objective->getId();
            $objectObjective->type = $objective->getType();
            $objectObjective->begin_at = $objective->getBeginAt();
            $objectObjective->end_at = $objective->getEndAt();
            $objectObjective->success = $objective->getSucess();

            $weight = $objectiveWeightRepository->findBy(["objective" => $objective->getId()]);

            foreach ($weight as $weightObjective) {
                $valueObjective = $weightObjective->getNumber();
            }

            $alcohol = $objectiveAlcoholRepository->findBy(["objective" => $objective->getId()]);

            foreach ($alcohol as $alcoholObjective) {
                $valueObjective = $alcoholObjective->getDrink();
            }

            $smoker = $objectiveSmokerRepository->findBy(["objective" => $objective->getId()]);

            foreach ($smoker as $smokerObjective) {
                $valueObjective = $smokerObjective->getNumber();
            }

            $sport = $objectiveSportRepository->findBy(["objective" => $objective->getId()]);

            foreach ($sport as $sportObjective) {
                $valueObjective = $sportObjective->getTime();
            }
            $objectObjective->valueObjectif = $valueObjective;

            if (isset($valueObjective)) {
                array_push($arrayObjective, $objectObjective);
            }

        }

        return new JsonResponse($arrayObjective);
    }

    /**
     * @Route("/api/validate-objective", name="validate_objective", methods={"PATCH"})
     * @param Request $request
     * @param ObjectivesRepository $objectivesRepository
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function Validation(Request $request, ObjectivesRepository $objectivesRepository, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        $user = $this->getUser();

        $objective = $objectivesRepository->findBy(["id" => $data['id']]);

        foreach ($objective as $value) {

            $value->setSucess(true);
            $em->persist($value);

            $em->flush();

        }

        return new JsonResponse("F??licitations vous avez valid?? votre objectif ! Ne vous arr??tez pas en si bon chemin !", Response::HTTP_OK);
    }

    /**
     * @Route("/api/delete-objective", name="delete_objective")
     * @param Request $request
     * @param ObjectivesRepository $objectivesRepository
     * @param ObjectiveSportRepository $objectiveSportRepository
     * @param ObjectiveSmokerRepository $objectiveSmokerRepository
     * @param ObjectiveAlcoholRepository $objectiveAlcoholRepository
     * @param ObjectiveWeightRepository $objectiveWeightRepository
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function Suppression(Request $request, ObjectivesRepository $objectivesRepository, ObjectiveSportRepository $objectiveSportRepository
        , ObjectiveSmokerRepository $objectiveSmokerRepository,ObjectiveAlcoholRepository $objectiveAlcoholRepository,ObjectiveWeightRepository $objectiveWeightRepository,EntityManagerInterface $em): Response
    {

        $data = json_decode($request->getContent(), true);
        $objectives = $objectivesRepository->findBy(["id" => $data['id']]);

        foreach ($objectives as $value){

           $type=$value->getType();

            if($type=='Cigarette'){
                $deleteObjective=$objectiveSmokerRepository->findBy(["id" => $value->getId()]);
            }else if($type=='Poids'){
                $deleteObjective=$objectiveWeightRepository->findBy(["id" => $value->getId()]);
            }else if($type=='Alcool'){
                $deleteObjective=$objectiveAlcoholRepository->find($value);
            }else if($type=='Sports'){
                $deleteObjective=$objectiveSportRepository->find($value);
            }
            return new JsonResponse($deleteObjective);

        }

        //$em->remove($deleteObjective);
        //$em->flush();

        //return new JsonResponse($deleteObjective);

    }

}
