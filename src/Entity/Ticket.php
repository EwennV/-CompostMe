<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 256)]
    private ?string $title = null;

    #[ORM\Column(length: 500)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $CreatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $UpdatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $ClosedAt = null;

    #[ORM\Column(length: 16)]
    private ?string $Statut = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $AuthorUser = null;

    #[ORM\ManyToOne(inversedBy: 'AttributedTickets')]
    private ?User $ResponsableUser = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Composter $Composter = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeImmutable $CreatedAt): static
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $UpdatedAt): static
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }

    public function getClosedAt(): ?\DateTimeImmutable
    {
        return $this->ClosedAt;
    }

    public function setClosedAt(?\DateTimeImmutable $ClosedAt): static
    {
        $this->ClosedAt = $ClosedAt;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->Statut;
    }

    public function setStatut(string $Statut): static
    {
        $this->Statut = $Statut;

        return $this;
    }

    public function getAuthorUser(): ?User
    {
        return $this->AuthorUser;
    }

    public function setAuthorUser(?User $AuthorUser): static
    {
        $this->AuthorUser = $AuthorUser;

        return $this;
    }

    public function getResponsableUser(): ?User
    {
        return $this->ResponsableUser;
    }

    public function setResponsableUser(?User $ResponsableUser): static
    {
        $this->ResponsableUser = $ResponsableUser;

        return $this;
    }

    public function getComposter(): ?Composter
    {
        return $this->Composter;
    }

    public function setComposter(?Composter $Composter): static
    {
        $this->Composter = $Composter;

        return $this;
    }
}
