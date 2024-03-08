<?php

namespace App\Entity;

use App\Repository\AccessTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccessTypeRepository::class)]
class AccessType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 12)]
    private ?string $name = null;

    #[ORM\OneToMany(targetEntity: Composter::class, mappedBy: 'AccessType')]
    private Collection $composters;

    public function __construct()
    {
        $this->composters = new ArrayCollection();
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
     * @return Collection<int, Composter>
     */
    public function getComposters(): Collection
    {
        return $this->composters;
    }

    public function addComposter(Composter $composter): static
    {
        if (!$this->composters->contains($composter)) {
            $this->composters->add($composter);
            $composter->setAccessType($this);
        }

        return $this;
    }

    public function removeComposter(Composter $composter): static
    {
        if ($this->composters->removeElement($composter)) {
            // set the owning side to null (unless already changed)
            if ($composter->getAccessType() === $this) {
                $composter->setAccessType(null);
            }
        }

        return $this;
    }
}
