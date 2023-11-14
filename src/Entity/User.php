<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\ApiResource\ApiRegisterController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/api/register',
            controller: ApiRegisterController::class,
            name: 'api_register_check'
        )
    ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToOne(mappedBy: 'user_id', cascade: ['persist', 'remove'])]
    private ?CompaniesProfile $companiesProfile = null;

    #[ORM\OneToOne(mappedBy: 'user_id', cascade: ['persist', 'remove'])]
    private ?UserProfile $userProfile = null;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Message::class)]
    private Collection $messages;

    #[ORM\OneToMany(mappedBy: 'companie_id', targetEntity: Advertisements::class)]
    private Collection $advertisements;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getCompaniesProfile(): ?CompaniesProfile
    {
        return $this->companiesProfile;
    }

    public function setCompaniesProfile(?CompaniesProfile $companiesProfile): static
    {
        // unset the owning side of the relation if necessary
        if ($companiesProfile === null && $this->companiesProfile !== null) {
            $this->companiesProfile->setUserId(null);
        }

        // set the owning side of the relation if necessary
        if ($companiesProfile !== null && $companiesProfile->getUserId() !== $this) {
            $companiesProfile->setUserId($this);
        }

        $this->companiesProfile = $companiesProfile;

        return $this;
    }

    public function getUserProfile(): ?UserProfile
    {
        return $this->userProfile;
    }

    public function setUserProfile(?UserProfile $userProfile): static
    {
        // unset the owning side of the relation if necessary
        if ($userProfile === null && $this->userProfile !== null) {
            $this->userProfile->setUserId(null);
        }

        // set the owning side of the relation if necessary
        if ($userProfile !== null && $userProfile->getUserId() !== $this) {
            $userProfile->setUserId($this);
        }

        $this->userProfile = $userProfile;

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setUserId($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getUserId() === $this) {
                $message->setUserId(null);
            }
        }

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
            $advertisement->setCompanieId($this);
        }

        return $this;
    }

    public function removeAdvertisement(Advertisements $advertisement): static
    {
        if ($this->advertisements->removeElement($advertisement)) {
            // set the owning side to null (unless already changed)
            if ($advertisement->getCompanieId() === $this) {
                $advertisement->setCompanieId(null);
            }
        }

        return $this;
    }
}
