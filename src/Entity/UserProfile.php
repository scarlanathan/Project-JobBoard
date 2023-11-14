<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\ApiResource\ApiGetUserInfo;
use App\Repository\UserProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserProfileRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/api/get_user_profile',
            controller: ApiGetUserInfo::class,
            name: 'api_get_userProfile'
        ),
        new Post(
            uriTemplate: '/api/update_user_profile',
            controller: ApiGetUserInfo::class,
            name: 'api_update_userProfile'
        )
    ]
)]
class UserProfile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $info_user = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $cv_path = null;

    #[ORM\OneToOne(inversedBy: 'userProfile', cascade: ['persist', 'remove'])]
    private ?User $user_id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $location = null;

    #[ORM\ManyToMany(targetEntity: Advertisements::class, mappedBy: 'user_candidate')]
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

    public function getInfoUser(): ?string
    {
        return $this->info_user;
    }

    public function setInfoUser(?string $info_user): static
    {
        $this->info_user = $info_user;

        return $this;
    }

    public function getCvPath(): ?string
    {
        return $this->cv_path;
    }

    public function setCvPath(?string $cv_path): static
    {
        $this->cv_path = $cv_path;

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

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

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
            $advertisement->addUserCandidate($this);
        }

        return $this;
    }

    public function removeAdvertisement(Advertisements $advertisement): static
    {
        if ($this->advertisements->removeElement($advertisement)) {
            $advertisement->removeUserCandidate($this);
        }

        return $this;
    }
}
