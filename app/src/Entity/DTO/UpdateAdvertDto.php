<?php

namespace App\Entity\DTO;

use App\Entity\Advert;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class UpdateAdvertDto
{
    #[Assert\NotBlank(message: "Name could not be blank", allowNull: true)]
    private ?string $title = null;

    #[Assert\NotBlank(message: "Description could not be blank", allowNull: true)]
    private ?string $description = null;

    #[Assert\NotBlank(message: "Price could not be blank", allowNull: true)]
    private ?float $price = null;

    #[Assert\NotBlank(message: "Price could not be blank", allowNull: true)]
    #[SerializedName(serializedName: 'zip_code')]
    private ?int $zipCode = null;

    #[SerializedName(serializedName: 'sale_city')]
    private ?string $saleCity = null;

    private bool $deleted;

    public function transformIntoAdvert(Advert $advert): Advert
    {
        if ($this->title) {
            $advert->setTitle($this->title);
        }
        if ($this->description) {
            $advert->setDescription($this->description);
        }
        if ($this->price) {
            $advert->setPrice($this->price);
        }
        if ($this->zipCode) {
            $advert->setZipCode($this->zipCode);
        }
        if ($this->saleCity) {
            $advert->setSaleCity($this->saleCity);
        }
        if ($this->deleted !== null) {
            $advert->setDeleted($this->deleted);
        }

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

    public function setDeleted(bool $deleted): static
    {
        $this->deleted = $deleted;

        return $this;
    }
}
