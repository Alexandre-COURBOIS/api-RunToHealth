<?php

namespace App\Controller;

use App\Form\UserContactInformationType;
use App\Form\UserInformationPasswordUpdateType;
use App\Form\UserInformationType;
use App\Repository\UsersRepository;
use App\Service\SecurityFunctions;
use App\Service\SerializerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


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

            $jsonContent = $this->serializerService->RelationSerializerGroups($user, 'json', 'users');

            return JsonResponse::fromJsonString($jsonContent);

        } else {
            return new JsonResponse("Please send a valid data", Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/api/user/update/contact", name="update_user_contact", methods={"PATCH"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     * @param UsersRepository $usersRepository
     * @return JsonResponse
     */
    public function updateUserContact(Request $request, EntityManagerInterface $em, ValidatorInterface $validator, UsersRepository $usersRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = $this->getUser();

        $form = $this->createForm(UserContactInformationType::class, $user);

        $form->submit($data);

        $validate = $validator->validate($user, null, 'UserContact');

        if (count($validate) !== 0) {
            foreach ($validate as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        $user->setUpdatedAt(new \DateTime());

        $em->persist($user);
        $em->flush();

        $jsonContent = $this->serializerService->RelationSerializerGroups($user, 'json', 'users');

        return JsonResponse::fromJsonString($jsonContent);
    }

    /**
     * @Route("/api/user/update/informations", name="update_user_informations", methods={"PATCH"})
     */
    public function updateUserInformations(Request $request, EntityManagerInterface $em, ValidatorInterface $validator): JsonResponse
    {
        $user = $this->getUser();

        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(UserInformationType::class, $user);

        $form->submit($data);

        $validate = $validator->validate($user, null, 'UserInformations');

        if (count($validate) !== 0) {
            foreach ($validate as $error) {
                return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
            }
        }

        $user->setUpdatedAt(new \DateTime());

        $em->persist($user);
        $em->flush();

        $jsonContent = $this->serializerService->RelationSerializerGroups($user, 'json', 'users');

        return JsonResponse::fromJsonString($jsonContent);
    }

    /**
     * @Route("/api/user/password/informations/update", name="informationsPasswordUpdate", methods={"PATCH"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param ValidatorInterface $validator
     * @param EntityManagerInterface $entityManager
     * @return JsonResponse
     */
    public function updatePasswordInformations(Request $request, UserPasswordEncoderInterface $passwordEncoder, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {

        //get the data
        $data = json_decode($request->getContent(), true);

        //get users with jwt token storage
        $user = $this->getUser();
        //get the oldpassword in data
        $oldPassword = $data['oldPassword'];

        //Get the both new passwords to compare them
        $newPassword = $data['password'];
        $verifNewpassword = $data['verifPassword'];

        // Compare if the both new password are identical
        if ($newPassword === $verifNewpassword) {
            //compare password in DB with typed oldpassword
            if (password_verify($oldPassword, $user->getPassword())) {

                $form = $this->createForm(UserInformationPasswordUpdateType::class, $user);

                $form->submit($data);

                $validate = $validator->validate($user, null, 'PasswordUpdate');

                if (count($validate) !== 0) {
                    foreach ($validate as $error) {
                        return new JsonResponse($error->getMessage(), Response::HTTP_BAD_REQUEST);
                    }
                }

                // Gestion du mot de passe
                $password = $passwordEncoder->encodePassword($user, $user->getPassword());

                $user->setPassword($password);
                $user->setUpdatedAt(new \DateTime());

                $entityManager->persist($user);
                $entityManager->flush();

                return new JsonResponse("Le mot de passe a été modifié avec succès !", Response::HTTP_OK);

            } else {
                return new JsonResponse("Le mot de passe actuel renseigné n'est pas valide", Response::HTTP_NOT_ACCEPTABLE);
            }
        } else {
            return new JsonResponse("Les nouveaux mot de passes saisis ne sont pas identiques", Response::HTTP_NOT_ACCEPTABLE);
        }
    }

}
