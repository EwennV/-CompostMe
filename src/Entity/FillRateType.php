<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Repository\FillRateTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FillRateTypeRepository::class)]
#[GetCollection]
#[Post(security: "is_granted('ROLE_ADMIN')")]
#[Get]
#[Post(security: "is_granted('ROLE_ADMIN')")]
class FillRateType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $pourcentage = null;

    #[ORM\Column(length: 16)]
    private ?string $color = null;

    #[ORM\OneToMany(targetEntity: Composter::class, mappedBy: 'fillRate')]
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

    public function getPourcentage(): ?int
    {
        return $this->pourcentage;
    }

    public function setPourcentage(int $pourcentage): static
    {
        $this->pourcentage = $pourcentage;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

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
            $composter->setFillRate($this);
        }

        return $this;
    }

    public function removeComposter(Composter $composter): static
    {
        if ($this->composters->removeElement($composter)) {
            // set the owning side to null (unless already changed)
            if ($composter->getFillRate() === $this) {
                $composter->setFillRate(null);
            }
        }

        return $this;
    }
}
