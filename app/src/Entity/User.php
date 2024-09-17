<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private readonly UuidInterface $id;

    #[Assert\NotBlank(message: 'Firstname is mandatory')]
    #[ORM\Column(length: 255)]
    #[SerializedName(serializedName: 'first_name')]
    private ?string $firstName = null;

    #[Assert\NotBlank(message: 'Lastname is mandatory')]
    #[ORM\Column(length: 255)]
    #[SerializedName(serializedName: 'last_name')]
    private ?string $lastName = null;

    #[Assert\NotBlank(message: 'Phone number is mandatory')]
    #[Assert\Regex(pattern: '/^\+?[1-9]\d{1,14}$/', message: 'Please enter a valid phone number')]
    #[ORM\Column(length: 255)]
    #[SerializedName(serializedName: 'phone_number')]
    private ?string $phoneNumber = null;

    #[Assert\NotBlank(message: 'Username is mandatory')]
    #[Assert\Email(message: 'Please enter a valid email address')]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[Assert\NotBlank(message: 'Password is mandatory')]
    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials()
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}
