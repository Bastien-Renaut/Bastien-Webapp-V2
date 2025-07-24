<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use App\Repository\SeanceExerciceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SeanceExerciceRepository::class)]
#[ORM\Table(name: 'seance_exercices')]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Delete()
    ],
    normalizationContext: ['groups' => ['seance_exercice:read']],
    denormalizationContext: ['groups' => ['seance_exercice:write']],
)]
class SeanceExercice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['seance_exercice:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'seanceExercices')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['seance_exercice:read', 'seance_exercice:write'])]
    private ?Seance $seance = null;

    #[ORM\ManyToOne(inversedBy: 'seanceExercices')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['seance_exercice:read', 'seance_exercice:write'])]
    private ?Exercice $exercice = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero]
    #[Groups(['seance_exercice:read', 'seance_exercice:write', 'seance:read'])]
    private ?int $ordreAffichage = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    #[Groups(['seance_exercice:read', 'seance_exercice:write', 'seance:read'])]
    private ?int $repetitions = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    #[Groups(['seance_exercice:read', 'seance_exercice:write', 'seance:read'])]
    private ?int $series = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    #[Groups(['seance_exercice:read', 'seance_exercice:write', 'seance:read'])]
    private ?int $dureeMinutes = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeance(): ?Seance
    {
        return $this->seance;
    }

    public function setSeance(?Seance $seance): static
    {
        $this->seance = $seance;
        return $this;
    }

    public function getExercice(): ?Exercice
    {
        return $this->exercice;
    }

    public function setExercice(?Exercice $exercice): static
    {
        $this->exercice = $exercice;
        return $this;
    }

    public function getOrdreAffichage(): ?int
    {
        return $this->ordreAffichage;
    }

    public function setOrdreAffichage(int $ordreAffichage): static
    {
        $this->ordreAffichage = $ordreAffichage;
        return $this;
    }

    public function getRepetitions(): ?int
    {
        return $this->repetitions;
    }

    public function setRepetitions(?int $repetitions): static
    {
        $this->repetitions = $repetitions;
        return $this;
    }

    public function getSeries(): ?int
    {
        return $this->series;
    }

    public function setSeries(?int $series): static
    {
        $this->series = $series;
        return $this;
    }

    public function getDureeMinutes(): ?int
    {
        return $this->dureeMinutes;
    }

    public function setDureeMinutes(?int $dureeMinutes): static
    {
        $this->dureeMinutes = $dureeMinutes;
        return $this;
    }
}