<?php

namespace App\Entity\DTO;

use App\Entity\Advert;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

#[OA\Schema(
    title: 'CreateAdvertDto',
    description: 'Data Transfer Object for creating an advert',
    required: ['title', 'description', 'price']
)]
class CreateAdvertDto
{
    #[Assert\NotBlank(message: "Name could not be blank")]
    #[OA\Property(
        description: 'The title of the advert',
        type: 'string',
        example: 'Brand new bike'
    )]
    private ?string $title = null;

    #[Assert\NotNull(message: "Description is mandatory")]
    #[Assert\NotBlank(message: "Description could not be blank")]
    private ?string $description = null;

    #[Assert\NotBlank(message: "Price could not be blank")]
    private ?float $price = null;

    #[Assert\NotBlank(message: "Price could not be blank")]
    #[SerializedName(serializedName: 'zip_code')]
    private ?int $zipCode = null;

    #[SerializedName(serializedName: 'sale_city')]
    private ?string $saleCity = null;

    public function transformIntoAdvert(): Advert
    {
        $advert = new Advert();
        $advert->setTitle($this->title);
        $advert->setDescription($this->description);
        $advert->setPrice($this->price);
        $advert->setZipCode($this->zipCode);
        $advert->setSaleCity($this->saleCity);

        return $advert;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function setZipCode(int $zipCode): static
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function setSaleCity(?string $saleCity): static
    {
        $this->saleCity = $saleCity;

        return $this;
    }
}
