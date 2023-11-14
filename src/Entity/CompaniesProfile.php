<?php

namespace App\Entity;

use App\Repository\CompaniesProfileRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompaniesProfileRepository::class)]
class CompaniesProfile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $location = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $info_companie = null;

    #[ORM\OneToOne(inversedBy: 'companiesProfile', cascade: ['persist', 'remove'])]
    private ?User $user_id = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\ManyToOne(inversedBy: 'companiesProfiles')]
    private ?CompanieCategories $categorie_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getInfoCompanie(): ?string
    {
        return $this->info_companie;
    }

    public function setInfoCompanie(?string $info_companie): static
    {
        $this->info_companie = $info_companie;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCategorieId(): ?CompanieCategories
    {
        return $this->categorie_id;
    }

    public function setCategorieId(?CompanieCategories $categorie_id): static
    {
        $this->categorie_id = $categorie_id;

        return $this;
    }
}
