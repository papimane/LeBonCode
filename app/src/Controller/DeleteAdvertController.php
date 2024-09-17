<?php

namespace App\Controller;

use App\Entity\Advert;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/advert/{id}', name: 'delete_advert', methods: ['DELETE'])]
#[OA\Response(
    response: 204,
    description: 'Deletes an advertisement',
)]
#[OA\Tag(name: 'Advertisement')]
#[Security(name: 'Bearer')]
class DeleteAdvertController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(Advert $id): JsonResponse
    {
        $advert = $id->setDeleted(true);
        $this->entityManager->persist($advert);
        $this->entityManager->flush();

        return new JsonResponse('', JsonResponse::HTTP_NO_CONTENT);
    }
}
