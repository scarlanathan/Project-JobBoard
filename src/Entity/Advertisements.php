<?php

namespace App\Entity;

use App\Repository\AdvertisementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdvertisementsRepository::class)]
class Advertisements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $start_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $end_date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type_contrat = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type_job = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $salary = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $work_time = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $public_date = null;

    #[ORM\ManyToOne(inversedBy: 'advertisements')]
    private ?User $companie_id = null;

    #[ORM\ManyToMany(targetEntity: JobCategories::class, inversedBy: 'advertisements')]
    private Collection $job_categories_id;

    #[ORM\Column(length: 255)]
    private ?string $name_job = null;

    #[ORM\ManyToMany(targetEntity: UserProfile::class, inversedBy: 'advertisements')]
    private Collection $user_candidate;

    #[ORM\ManyToMany(targetEntity: CandidateAnonymous::class, inversedBy: 'advertisements')]
    private Collection $canditate_anonymous;

    public function __construct()
    {
        $this->job_categories_id = new ArrayCollection();
        $this->user_candidate = new ArrayCollection();
        $this->canditate_anonymous = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(?\DateTimeInterface $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getTypeContrat(): ?string
    {
        return $this->type_contrat;
    }

    public function setTypeContrat(?string $type_contrat): static
    {
        $this->type_contrat = $type_contrat;

        return $this;
    }

    public function getTypeJob(): ?string
    {
        return $this->type_job;
    }

    public function setTypeJob(?string $type_job): static
    {
        $this->type_job = $type_job;

        return $this;
    }

    public function getSalary(): ?string
    {
        return $this->salary;
    }

    public function setSalary(?string $salary): static
    {
        $this->salary = $salary;

        return $this;
    }

    public function getWorkTime(): ?string
    {
        return $this->work_time;
    }

    public function setWorkTime(?string $work_time): static
    {
        $this->work_time = $work_time;

        return $this;
    }

    public function getPublicDate(): ?\DateTimeInterface
    {
        return $this->public_date;
    }

    public function setPublicDate(\DateTimeInterface $public_date): static
    {
        $this->public_date = $public_date;

        return $this;
    }

    public function getCompanieId(): ?User
    {
        return $this->companie_id;
    }

    public function setCompanieId(?User $companie_id): static
    {
        $this->companie_id = $companie_id;

        return $this;
    }

    /**
     * @return Collection<int, JobCategories>
     */
    public function getJobCategoriesId(): Collection
    {
        return $this->job_categories_id;
    }

    public function addJobCategoriesId(JobCategories $jobCategoriesId): static
    {
        if (!$this->job_categories_id->contains($jobCategoriesId)) {
            $this->job_categories_id->add($jobCategoriesId);
        }

        return $this;
    }

    public function removeJobCategoriesId(JobCategories $jobCategoriesId): static
    {
        $this->job_categories_id->removeElement($jobCategoriesId);

        return $this;
    }

    public function getNameJob(): ?string
    {
        return $this->name_job;
    }

    public function setNameJob(string $name_job): static
    {
        $this->name_job = $name_job;

        return $this;
    }

    /**
     * @return Collection<int, UserProfile>
     */
    public function getUserCandidate(): Collection
    {
        return $this->user_candidate;
    }


    public function addUserCandidate(UserProfile $userCandidate): static
    {
        if (!$this->user_candidate->contains($userCandidate)) {
            $this->user_candidate->add($userCandidate);
        }

        return $this;
    }


    public function removeUserCandidate(UserProfile $userCandidate): static
    {
        $this->user_candidate->removeElement($userCandidate);

        return $this;
    }

    /**
     * @return Collection<int, CandidateAnonymous>
     */
    public function getCanditateAnonymous(): Collection
    {
        return $this->canditate_anonymous;
    }

    public function addCanditateAnonymou(CandidateAnonymous $canditateAnonymou): static
    {
        if (!$this->canditate_anonymous->contains($canditateAnonymou)) {
            $this->canditate_anonymous->add($canditateAnonymou);
        }

        return $this;
    }

    public function removeCanditateAnonymou(CandidateAnonymous $canditateAnonymou): static
    {
        $this->canditate_anonymous->removeElement($canditateAnonymou);

        return $this;
    }
}
