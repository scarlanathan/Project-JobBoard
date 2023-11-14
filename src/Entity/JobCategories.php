<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\ApiResource\ApiJobCategories;
use App\Repository\JobCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobCategoriesRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/api/job_categories',
            controller: ApiJobCategories::class,
            name: 'api_job_categories'
        )
    ]
)]
class JobCategories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Advertisements::class, mappedBy: 'job_categories_id')]
    private Collection $advertisements;

    public function __construct()
    {
        $this->advertisements = new ArrayCollection();
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
     * @return Collection<int, Advertisements>
     */
    public function getAdvertisements(): Collection
    {
        return $this->advertisements;
    }

    public function addAdvertisement(Advertisements $advertisement): static
    {
        if (!$this->advertisements->contains($advertisement)) {
            $this->advertisements->add($advertisement);
            $advertisement->addJobCategoriesId($this);
        }
        return $this;
    }

    public function removeAdvertisement(Advertisements $advertisement): static
    {
        if ($this->advertisements->removeElement($advertisement)) {
            $advertisement->removeJobCategoriesId($this);
        }
        return $this;
    }
}
