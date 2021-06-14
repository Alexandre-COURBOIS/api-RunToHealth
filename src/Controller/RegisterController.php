<?php

namespace App\Controller;

use App\Entity\Characteristics;
use App\Entity\Users;
use App\Entity\Weight;
use App\Form\UserRegistrationCharacteristicsType;
use App\Form\UserRegistrationType;
use App\Form\UserRegistrationWeightType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegisterController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->manager = $entityManager;
    }

    /**
     * @Route("/register/user", name="register")
     */
    public function registerUser(Request $request, ValidatorInterface $validator, UserPasswordEncoderInterface $passwordEncoder): JsonResponse
    {
        $user = new Users();

        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(UserRegistrationType::class, $user);

        $form->submit($data);

        $validate = $validator->validate($user, null, 'Register');

        if (count($validate) !== 0) {
            foreach ($validate as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        $password = $passwordEncoder->encodePassword($user, $user->getPassword());

        $user->setPassword($password);
        $user->setActive(false);

        $this->manager->persist($user);

        $weight = new Weight();

        $formWeight = $this->createForm(UserRegistrationWeightType::class, $weight);

        $formWeight->submit($data);

        $validateWeight = $validator->validate($weight, null, 'Register');

        if (count($validateWeight) !== 0) {
            foreach ($validateWeight as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        $this->manager->persist($weight);

        $characteristics = new Characteristics();

        $characteristics->setUsers($user);
        $characteristics->setWeight($weight);

        $formChar = $this->createForm(UserRegistrationCharacteristicsType::class, $characteristics);

        $formChar->submit($data);

        $validateChar = $validator->validate($characteristics, null, 'Register');

        if (count($validateChar) !== 0) {
            foreach ($validateChar as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        $this->manager->persist($characteristics);

        $this->manager->flush();

        return new JsonResponse("User has been created successfully", Response::HTTP_CREATED);
    }
}
