<?php

namespace App\Entity;

use App\Repository\ComposterDayRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComposterDayRepository::class)]
class ComposterDay
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'composterDays')]
    #[ORM\JoinColumn(nullable: false)]
    private ?composter $composter = null;

    #[ORM\ManyToOne(inversedBy: 'composterDays')]
    #[ORM\JoinColumn(nullable: false)]
    private ?day $day = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $openingTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $closureTime = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComposter(): ?composter
    {
        return $this->composter;
    }

    public function setComposter(?composter $composter): static
    {
        $this->composter = $composter;

        return $this;
    }

    public function getDay(): ?day
    {
        return $this->day;
    }

    public function setDay(?day $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function getOpeningTime(): ?\DateTimeInterface
    {
        return $this->openingTime;
    }

    public function setOpeningTime(\DateTimeInterface $openingTime): static
    {
        $this->openingTime = $openingTime;

        return $this;
    }

    public function getClosureTime(): ?\DateTimeInterface
    {
        return $this->closureTime;
    }

    public function setClosureTime(\DateTimeInterface $closureTime): static
    {
        $this->closureTime = $closureTime;

        return $this;
    }
}
