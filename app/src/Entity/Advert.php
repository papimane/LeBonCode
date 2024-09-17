<?php

namespace App\Entity;

use App\Repository\AdvertRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AdvertRepository::class)]
class Advert
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]

    private readonly UuidInterface $id;

    #[Assert\NotBlank(message: "Name could not be blank")]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Assert\NotNull(message: "Description is mandatory")]
    #[Assert\NotBlank(message: "Description could not be blank")]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[Assert\NotBlank(message: "Price could not be blank")]
    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: "Price could not be blank")]
    #[SerializedName(serializedName: 'zip_code')]
    private ?int $zipCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[SerializedName(serializedName: 'sale_city')]
    private ?string $saleCity = null;

    #[ORM\Column(type: 'boolean')]
    private bool $deleted = false;

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): static
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getSaleCity(): ?string
    {
        return $this->saleCity;
    }

    public function setSaleCity(?string $saleCity): static
    {
        $this->saleCity = $saleCity;

        return $this;
    }

    public function isDeleted(): bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): static
    {
        $this->deleted = $deleted;

        return $this;
    }
}
