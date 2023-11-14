<?php

namespace App\Entity;

use App\Repository\CandidateAnonymousRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\BlobType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidateAnonymousRepository::class)]
class CandidateAnonymous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\ManyToMany(targetEntity: Advertisements::class, mappedBy: 'canditate_anonymous')]
    private Collection $advertisements;


    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $cv = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $lm = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;


    public function __construct()
    {
        $this->advertisements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

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
            $advertisement->addCanditateAnonymou($this);
        }

        return $this;
    }

    public function removeAdvertisement(Advertisements $advertisement): static
    {
        if ($this->advertisements->removeElement($advertisement)) {
            $advertisement->removeCanditateAnonymou($this);
        }

        return $this;
    }


    public function getCv()
    {
        return $this->cv;
    }

    public function setCv($cv): static
    {
        $this->cv = $cv;

        return $this;
    }

    public function getLm(): ?string
    {
        return $this->lm;
    }

    public function setLm(?string $lm): static
    {
        $this->lm = $lm;

        return $this;
    }
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;


        return $this;
    }
}
