<?php

namespace App\Entity;

use App\Repository\DayRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DayRepository::class)]
class Day
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: ComposterDay::class, mappedBy: 'day', orphanRemoval: true)]
    private Collection $composterDays;

    public function __construct()
    {
        $this->composterDays = new ArrayCollection();
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
            $composterDay->setDay($this);
        }

        return $this;
    }

    public function removeComposterDay(ComposterDay $composterDay): static
    {
        if ($this->composterDays->removeElement($composterDay)) {
            // set the owning side to null (unless already changed)
            if ($composterDay->getDay() === $this) {
                $composterDay->setDay(null);
            }
        }

        return $this;
    }
}
