<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\ComposterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComposterRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post()
    ],
)]
class Composter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $longitude = null;

    #[ORM\Column]
    private ?float $latitude = null;

    #[ORM\Column(length: 255)]
    private ?string $contact = null;

    #[ORM\ManyToOne(inversedBy: 'composters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?OwnerType $OwnerType = null;

    #[ORM\ManyToOne(inversedBy: 'composters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AccessType $AccessType = null;

    #[ORM\ManyToOne(inversedBy: 'composters')]
    private ?FillRateType $FillRate = null;

    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'Composter')]
    private Collection $tickets;

    public function __construct()
    {
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function getOwnerType(): ?OwnerType
    {
        return $this->OwnerType;
    }

    public function setOwnerType(?OwnerType $OwnerType): static
    {
        $this->OwnerType = $OwnerType;

        return $this;
    }

    public function getAccessType(): ?AccessType
    {
        return $this->AccessType;
    }

    public function setAccessType(?AccessType $AccessType): static
    {
        $this->AccessType = $AccessType;

        return $this;
    }

    public function getFillRate(): ?FillRateType
    {
        return $this->FillRate;
    }

    public function setFillRate(?FillRateType $FillRate): static
    {
        $this->FillRate = $FillRate;

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
            $ticket->setComposter($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): static
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getComposter() === $this) {
                $ticket->setComposter(null);
            }
        }

        return $this;
    }
}
