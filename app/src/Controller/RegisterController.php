<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(path: '/register', name: 'register', methods: ['POST'])]
#[OA\Response(
    response: 200,
    description: 'Authenticate',
)]
#[OA\Tag(name: 'Registration')]
class RegisterController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = $this->serializer->deserialize(
            $request->getContent(),
            User::class,
            'json'
        );

        $errors = $this->validator->validate($user);

        if (count($errors) > 0) {
            $errorMessages = [];

            foreach ($errors as $violation) {
                $errorMessages[] = $violation->getMessage();
            }

            return new JsonResponse(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $user->getPassword()
        );

        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->json([
            'id' => $user->getId()->toString(),
        ]);
    }
}
