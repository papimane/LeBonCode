<?php

namespace App\Controller;

use App\Entity\DTO\CreateAdvertDto;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route(path: '/advert', name: 'create_advert', methods: ['POST'])]
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

class CreateAdvertController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        /** @var CreateAdvertDto $createAdvertDTO */
        $createAdvertDTO = $this->serializer->deserialize(
            $request->getContent(),
            CreateAdvertDto::class,
            'json'
        );

        $errors = $this->validator->validate($createAdvertDTO);

        if (count($errors) > 0) {
            $errorMessages = [];

            foreach ($errors as $violation) {
                $errorMessages[] = $violation->getMessage();
            }

            return new JsonResponse(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($advert = $createAdvertDTO->transformIntoAdvert());
        $this->entityManager->flush();

        return $this->json([
            'id' => $advert->getId()->toString(),
        ]);
    }
}
