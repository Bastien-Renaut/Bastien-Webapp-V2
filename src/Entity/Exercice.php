<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use App\Repository\ExerciceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ExerciceRepository::class)]
#[ORM\Table(name: 'exercices')]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Delete()
    ],
    normalizationContext: ['groups' => ['exercice:read']],
    denormalizationContext: ['groups' => ['exercice:write']],
)]
class Exercice
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['exercice:read', 'seance_exercice:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    #[Groups(['exercice:read', 'exercice:write', 'seance_exercice:read'])]
    private ?string $nomExercice = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['exercice:read', 'exercice:write'])]
    private ?string $descriptionExercice = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: ['force', 'cardio', 'flexibilite', 'equilibre', 'autre'])]
    #[Groups(['exercice:read', 'exercice:write'])]
    private ?string $typeExercice = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['exercice:read'])]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['exercice:read'])]
    private ?\DateTimeInterface $dateMiseAJour = null;

    #[ORM\OneToMany(mappedBy: 'exercice', targetEntity: SeanceExercice::class, orphanRemoval: true)]
    #[Groups(['exercice:read'])]
    private Collection $seanceExercices;

    public function __construct()
    {
        $this->seanceExercices = new ArrayCollection();
        $this->dateCreation = new \DateTime();
        $this->dateMiseAJour = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomExercice(): ?string
    {
        return $this->nomExercice;
    }

    public function setNomExercice(string $nomExercice): static
    {
        $this->nomExercice = $nomExercice;
        $this->dateMiseAJour = new \DateTime();
        return $this;
    }

    public function getDescriptionExercice(): ?string
    {
        return $this->descriptionExercice;
    }

    public function setDescriptionExercice(?string $descriptionExercice): static
    {
        $this->descriptionExercice = $descriptionExercice;
        $this->dateMiseAJour = new \DateTime();
        return $this;
    }

    public function getTypeExercice(): ?string
    {
        return $this->typeExercice;
    }

    public function setTypeExercice(string $typeExercice): static
    {
        $this->typeExercice = $typeExercice;
        $this->dateMiseAJour = new \DateTime();
        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    public function getDateMiseAJour(): ?\DateTimeInterface
    {
        return $this->dateMiseAJour;
    }

    public function setDateMiseAJour(\DateTimeInterface $dateMiseAJour): static
    {
        $this->dateMiseAJour = $dateMiseAJour;
        return $this;
    }

    /**
     * @return Collection<int, SeanceExercice>
     */
    public function getSeanceExercices(): Collection
    {
        return $this->seanceExercices;
    }

    public function addSeanceExercice(SeanceExercice $seanceExercice): static
    {
        if (!$this->seanceExercices->contains($seanceExercice)) {
            $this->seanceExercices->add($seanceExercice);
            $seanceExercice->setExercice($this);
        }
        return $this;
    }

    public function removeSeanceExercice(SeanceExercice $seanceExercice): static
    {
        if ($this->seanceExercices->removeElement($seanceExercice)) {
            if ($seanceExercice->getExercice() === $this) {
                $seanceExercice->setExercice(null);
            }
        }
        return $this;
    }
}