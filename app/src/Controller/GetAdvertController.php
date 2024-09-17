<?php

namespace App\Controller;

use App\Entity\Advert;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(path: '/advert/{id}', name: 'get_advert', methods: ['GET'])]
#[OA\Response(
    response: 200,
    description: 'Get an advertisement',
)]
#[OA\Tag(name: 'Advertisement')]
#[Security(name: 'Bearer')]
class GetAdvertController extends AbstractController
{
    public function __construct(private SerializerInterface $serializer)
    {
    }

    public function __invoke(Advert $id): JsonResponse
    {
        $jsonContent = $this->serializer->serialize($id, 'json');

        return new JsonResponse($jsonContent , JsonResponse::HTTP_OK, [], true);
    }
}
