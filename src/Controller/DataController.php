<?php

namespace App\Controller;

use App\Entity\ObjectiveAlcohol;
use App\Entity\Objectives;
use App\Entity\ObjectiveSmoker;
use App\Entity\ObjectiveSport;
use App\Entity\ObjectiveWeight;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->manager = $entityManager;
    }

    /**
     * @Route("/data", name="data")
     * @param Request $request
     * @param UsersRepository $usersRepository
     * @return Response
     * @throws \Exception
     */
    public function index(Request $request,UsersRepository $usersRepository): Response
    {
        $objective= new Objectives();
        $user= $usersRepository->findOneBy(["email"=>"julien@gmail.com"]);

        $data = json_decode($request->getContent(), true);

        if(isset($data)) {

            $objective->setUser($user);
            $objective->setCreatedAt(date_create());
            $objective->setUpdateAt(date_create());
            $objective->setSucess(false);
            $objective->setBeginAt(date("d/m/Y", strtotime($data['begin'])));
            $objective->setEndAt(date("d/m/Y", strtotime($data['end'])));
            $objective->setType($data['objectif']);

            $this->manager->persist($objective);
            $this->manager->flush();

            if ($data['objectif']==="Poids") {

                $weight = new ObjectiveWeight();
                $weight->setNumber($data['numberPoids']);
                $weight->setCreatedAt(date_create());
                $weight->setObjective($objective);

                $this->manager->persist($weight);

            }else if($data['objectif']==="Alcool"){

                $alcool= new ObjectiveAlcohol();
                $alcool->setDrink($data['alcool']);
                $alcool->setCreatedAt(date_create());
                $alcool->setObjective($objective);

                $this->manager->persist($alcool);

            }else if($data['objectif']==="Sport"){

                $sport=new ObjectiveSport();
                $sport->setTime(date("h:i:s", strtotime($data['timeSport'])));
                $sport->setCreatedAt(date_create());
                $sport->setObjective($objective);

                $this->manager->persist($sport);

            }else if($data['objectif']==="Cigarette"){

                $smoker=new ObjectiveSmoker();
                $smoker->setNumber($data['numberCigarette']);
                $smoker->setCreatedAt(date_create());
                $smoker->setObjective($objective);

                $this->manager->persist($smoker);
            }

            $this->manager->flush();

            return $this->json(
                $data,
            );

        }else{
            return $this->json([
                'root' => 'data does not exist'

            ]);
        }

    }
}

