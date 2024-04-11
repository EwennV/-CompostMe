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
#[Get]
#[GetCollection]
#[Post(security: "is_granted('ROLE_ADMIN')")]
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
    private ?OwnerType $ownerType = null;

    #[ORM\ManyToOne(inversedBy: 'composters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AccessType $accessType = null;

    #[ORM\ManyToOne(inversedBy: 'composters')]
    private ?FillRateType $fillRate = null;

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
        return $this->ownerType;
    }

    public function setOwnerType(?OwnerType $ownerType): static
    {
        $this->ownerType = $ownerType;

        return $this;
    }

    public function getAccessType(): ?AccessType
    {
        return $this->accessType;
    }

    public function setAccessType(?AccessType $accessType): static
    {
        $this->accessType = $accessType;

        return $this;
    }

    public function getFillRate(): ?FillRateType
    {
        return $this->fillRate;
    }

    public function setFillRate(?FillRateType $fillRate): static
    {
        $this->fillRate = $fillRate;

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
