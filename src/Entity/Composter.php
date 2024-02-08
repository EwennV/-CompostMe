<?php

namespace App\Entity;

use App\Repository\ComposterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComposterRepository::class)]
class Composter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $latitude = null;

    #[ORM\Column]
    private ?float $longitude = null;

    #[ORM\ManyToOne(inversedBy: 'composters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ownerType $ownerType = null;

    #[ORM\ManyToOne(inversedBy: 'composters')]
    #[ORM\JoinColumn(nullable: false)]
    private ?accessType $accessType = null;

    #[ORM\ManyToOne(inversedBy: 'composters')]
    private ?fillRateType $fillRateType = null;

    #[ORM\OneToMany(targetEntity: ComposterDay::class, mappedBy: 'composter', orphanRemoval: true)]
    private Collection $composterDays;

    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'composter', orphanRemoval: true)]
    private Collection $tickets;

    public function __construct()
    {
        $this->composterDays = new ArrayCollection();
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getOwnerType(): ?ownerType
    {
        return $this->ownerType;
    }

    public function setOwnerType(?ownerType $ownerType): static
    {
        $this->ownerType = $ownerType;

        return $this;
    }

    public function getAccessType(): ?accessType
    {
        return $this->accessType;
    }

    public function setAccessType(?accessType $accessType): static
    {
        $this->accessType = $accessType;

        return $this;
    }

    public function getFillRateType(): ?fillRateType
    {
        return $this->fillRateType;
    }

    public function setFillRateType(?fillRateType $fillRateType): static
    {
        $this->fillRateType = $fillRateType;

        return $this;
    }

    /**
     * @return Collection<int, ComposterDay>
     */
    public function getComposterDays(): Collection
    {
        return $this->composterDays;
    }

    public function addComposterDay(ComposterDay $composterDay): static
    {
        if (!$this->composterDays->contains($composterDay)) {
            $this->composterDays->add($composterDay);
            $composterDay->setComposter($this);
        }

        return $this;
    }

    public function removeComposterDay(ComposterDay $composterDay): static
    {
        if ($this->composterDays->removeElement($composterDay)) {
            // set the owning side to null (unless already changed)
            if ($composterDay->getComposter() === $this) {
                $composterDay->setComposter(null);
            }
        }

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
