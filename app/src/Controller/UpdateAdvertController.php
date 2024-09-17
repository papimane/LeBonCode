<?php

namespace App\Controller;

use App\Entity\Advert;
use App\Entity\DTO\UpdateAdvertDto;
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

#[Route(path: '/advert/{id}', name: 'edit_advert', methods: ['PATCH'])]
#[OA\Response(
    response: 200,
    description: 'Updates an advertisement',
    content: new OA\JsonContent(
        type: 'array',
        items: new OA\Items(ref: new Model(type: UpdateAdvertDto::class, groups: ['full']))
    )
)]
#[OA\Tag(name: 'Advertisement')]
#[Security(name: 'Bearer')]
class UpdateAdvertController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function __invoke(Request $request, Advert $id): JsonResponse
    {
        /** @var UpdateAdvertDto $updateAdvertDTO */
        $updateAdvertDTO = $this->serializer->deserialize(
            $request->getContent(),
            UpdateAdvertDto::class,
            'json'
        );

        $errors = $this->validator->validate($updateAdvertDTO);

        if (count($errors) > 0) {
            $errorMessages = [];

            foreach ($errors as $violation) {
                $errorMessages[] = $violation->getMessage();
            }

            return new JsonResponse(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }

        $this->entityManager->persist($advert = $updateAdvertDTO->transformIntoAdvert($id));
        $this->entityManager->flush();

        return $this->json([
            'id' => $advert->getId()->toString(),
        ]);
    }
}
