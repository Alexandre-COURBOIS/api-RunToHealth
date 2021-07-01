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

        $user=$usersRepository->findOneBy(["email"=>"julien.mallet.pro@gmail.com"]);

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

    /**
     * @Route("/search/objective", name="search_objective")
     * @param Request $request
     * @param ObjectivesRepository $objectivesRepository
     * @param ObjectiveWeightRepository $objectiveWeightRepository
     * @param ObjectiveAlcoholRepository $objectiveAlcoholRepository
     * @param ObjectiveSmokerRepository $objectiveSmokerRepository
     * @param ObjectiveSportRepository $objectiveSportRepository
     * @return Response
     */
    public function search_objective(Request $request,ObjectivesRepository $objectivesRepository,ObjectiveWeightRepository $objectiveWeightRepository
        ,ObjectiveAlcoholRepository $objectiveAlcoholRepository, ObjectiveSmokerRepository $objectiveSmokerRepository,ObjectiveSportRepository $objectiveSportRepository): Response
    {

        $data = json_decode($request->getContent(), true);

        $objectives=$objectivesRepository->findBy(["id"=>$data]);

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

    /**
     * @Route("/validation", name="validation")
     * @param Request $request
     * @param ObjectivesRepository $objectivesRepository
     * @return Response
     */
    public function Validation(Request $request,ObjectivesRepository $objectivesRepository): Response
    {




    }

    /**
     * @Route("/suppression", name="suppression")
     * @param Request $request
     * @param ObjectivesRepository $objectivesRepository
     * @param ObjectiveSportRepository $objectiveSportRepository
     * @param ObjectiveSmokerRepository $objectiveSmokerRepository
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function Suppression(Request $request,ObjectivesRepository $objectivesRepository,ObjectiveSportRepository $objectiveSportRepository
        ,ObjectiveSmokerRepository $objectiveSmokerRepository,EntityManagerInterface $em): Response
    {

        $data = json_decode($request->getContent(), true);
        $objectives=$objectivesRepository->find(["id"=>2]);

        $sport=$objectiveSportRepository->find($objectives);

        $em->remove($sport);
        $em->flush();
        /*$em->remove($sport);
        $em->flush();*/

        return new JsonResponse('ff');

    }

}
