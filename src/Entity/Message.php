<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    private ?User $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'messages')]
    private ?User $companie_id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $send_date = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $obj = null;

    #[ORM\Column]
    private ?bool $send_type = null;

    #[ORM\Column]
    private ?bool $user_delete = null;

    #[ORM\Column]
    private ?bool $companie_delete = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCompanieId(): ?User
    {
        return $this->companie_id;
    }

    public function setCompanieId(?User $companie_id): static
    {
        $this->companie_id = $companie_id;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getSendDate(): ?\DateTimeInterface
    {
        return $this->send_date;
    }

    public function setSendDate(\DateTimeInterface $send_date): static
    {
        $this->send_date = $send_date;

        return $this;
    }

    public function getObj(): ?string
    {
        return $this->obj;
    }

    public function setObj(?string $obj): static
    {
        $this->obj = $obj;

        return $this;
    }

    public function isSendType(): ?bool
    {
        return $this->send_type;
    }

    public function setSendType(bool $send_type): static
    {
        $this->send_type = $send_type;

        return $this;
    }

    public function isUserDelete(): ?bool
    {
        return $this->user_delete;
    }

    public function setUserDelete(bool $user_delete): static
    {
        $this->user_delete = $user_delete;

        return $this;
    }

    public function isCompanieDelete(): ?bool
    {
        return $this->companie_delete;
    }

    public function setCompanieDelete(bool $companie_delete): static
    {
        $this->companie_delete = $companie_delete;

        return $this;
    }
}
