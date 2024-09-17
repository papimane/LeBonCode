<?php

namespace App\Controller;

use App\Entity\User;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;


#[Route(path: '/login', name: 'login', methods: ['POST'])]
#[OA\Response(
    response: 200,
    description: 'Authenticate',
)]
#[OA\Tag(name: 'Registration')]
class LoginController extends AbstractController
{

    public function __invoke(#[CurrentUser] ?User $user): JsonResponse
    {
        if (null === $user) {
            return $this->json([
             'message' => 'Wrong or missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $this->json([
            'token' => $this->container->get('lexik_jwt_authentication.jwt_manager')->create($user),
        ]);
    }
}
