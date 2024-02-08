<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $firstname = null;

    #[ORM\Column(length: 64)]
    private ?string $lastname = null;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $pseudo = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    private ?userType $type = null;

    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'author', orphanRemoval: true)]
    private Collection $tickets;

    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'responsable')]
    private Collection $traitedTickets;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
        $this->traitedTickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): static
    {
        $this->pseudo = $pseudo;

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

    public function getType(): ?userType
    {
        return $this->type;
    }

    public function setType(?userType $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): static
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->setAuthor($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): static
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getAuthor() === $this) {
                $ticket->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTraitedTickets(): Collection
    {
        return $this->traitedTickets;
    }

    public function addTraitedTicket(Ticket $traitedTicket): static
    {
        if (!$this->traitedTickets->contains($traitedTicket)) {
            $this->traitedTickets->add($traitedTicket);
            $traitedTicket->setResponsable($this);
        }

        return $this;
    }

    public function removeTraitedTicket(Ticket $traitedTicket): static
    {
        if ($this->traitedTickets->removeElement($traitedTicket)) {
            // set the owning side to null (unless already changed)
            if ($traitedTicket->getResponsable() === $this) {
                $traitedTicket->setResponsable(null);
            }
        }

        return $this;
    }
}
