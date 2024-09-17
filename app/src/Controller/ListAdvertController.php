<?php

namespace App\Controller;

use App\Entity\DTO\CreateAdvertDto;
use App\Repository\AdvertRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route(path: '/advert', name: 'list_advert', methods: ['GET'])]
#[OA\Response(
    response: 200,
    description: 'Creates an advertisement',
    content: new OA\JsonContent(
        type: 'array',
        items: new OA\Items(ref: new Model(type: CreateAdvertDto::class, groups: ['full']))
    )
)]
#[OA\Tag(name: 'Advertisement')]
#[Security(name: 'Bearer')]
class ListAdvertController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private AdvertRepository $repository
    ) {
    }

    public function __invoke(): JsonResponse
    {
        $adverts = $this->repository->findAll();
        $jsonContent = $this->serializer->serialize($adverts, 'json');

        return new JsonResponse($jsonContent , JsonResponse::HTTP_OK, [], true);
    }
}
