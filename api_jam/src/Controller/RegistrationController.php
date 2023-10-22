<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/api')]
class RegistrationController extends AbstractController {

    private $userRepository;
    private $serializer;
    private $validator;
    private $entityManager;

    public function __construct(UserRepository $userRepository, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->entityManager = $entityManager;
    }

    #[Route('/register', name: 'register', methods: ["POST"])]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher): JsonResponse {
        
        $data = $request->getContent();
        $user = $this->serializer->deserialize($data, User::class, 'json');

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            $errorMessages = [];

            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }

            return new JsonResponse(['errors' => $errorMessages], 400);
        }

        $user->setPassword($userPasswordHasher->hashPassword($user, $user->getPassword()));

        $this->entityManager->persist($user); // Utilisez l'EntityManager pour persister l'entité
        $this->entityManager->flush(); // Utilisez l'EntityManager pour enregistrer les changements

        return new JsonResponse(['message' => 'User created'], 201);
    }
}
