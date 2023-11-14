<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\ApiResource\ApiCompanieCategorie;
use App\Repository\CompanieCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanieCategoriesRepository::class)]
#[ApiResource(
    operations:[
        new Get(
            uriTemplate: '/api/companies_categorie',
            controller: ApiCompanieCategorie::class,
            name: 'api_companies_categories'
        )
    ]
)]
class CompanieCategories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'categorie_id', targetEntity: CompaniesProfile::class)]
    private Collection $companiesProfiles;

    public function __construct()
    {
        $this->companiesProfiles = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, CompaniesProfile>
     */
    public function getCompaniesProfiles(): Collection
    {
        return $this->companiesProfiles;
    }

    public function addCompaniesProfile(CompaniesProfile $companiesProfile): static
    {
        if (!$this->companiesProfiles->contains($companiesProfile)) {
            $this->companiesProfiles->add($companiesProfile);
            $companiesProfile->setCategorieId($this);
        }

        return $this;
    }

    public function removeCompaniesProfile(CompaniesProfile $companiesProfile): static
    {
        if ($this->companiesProfiles->removeElement($companiesProfile)) {
            // set the owning side to null (unless already changed)
            if ($companiesProfile->getCategorieId() === $this) {
                $companiesProfile->setCategorieId(null);
            }
        }

        return $this;
    }
}
