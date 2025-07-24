<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use App\Repository\SeanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SeanceRepository::class)]
#[ORM\Table(name: 'seances')]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Delete()
    ],
    normalizationContext: ['groups' => ['seance:read']],
    denormalizationContext: ['groups' => ['seance:write']],
)]
class Seance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['seance:read', 'programme:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    #[Groups(['seance:read', 'seance:write', 'programme:read'])]
    private ?string $nomSeance = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['seance:read', 'seance:write'])]
    private ?string $descriptionSeance = null;

    #[ORM\ManyToOne(inversedBy: 'seances')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['seance:read', 'seance:write'])]
    private ?Programme $programme = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['seance:read'])]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['seance:read'])]
    private ?\DateTimeInterface $dateMiseAJour = null;

    #[ORM\OneToMany(mappedBy: 'seance', targetEntity: SeanceExercice::class, orphanRemoval: true)]
    #[Groups(['seance:read'])]
    private Collection $seanceExercices;

    #[ORM\OneToMany(mappedBy: 'seance', targetEntity: Entrainement::class)]
    #[Groups(['seance:read'])]
    private Collection $entrainements;

    public function __construct()
    {
        $this->seanceExercices = new ArrayCollection();
        $this->entrainements = new ArrayCollection();
        $this->dateCreation = new \DateTime();
        $this->dateMiseAJour = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSeance(): ?string
    {
        return $this->nomSeance;
    }

    public function setNomSeance(string $nomSeance): static
    {
        $this->nomSeance = $nomSeance;
        $this->dateMiseAJour = new \DateTime();
        return $this;
    }

    public function getDescriptionSeance(): ?string
    {
        return $this->descriptionSeance;
    }

    public function setDescriptionSeance(?string $descriptionSeance): static
    {
        $this->descriptionSeance = $descriptionSeance;
        $this->dateMiseAJour = new \DateTime();
        return $this;
    }

    public function getProgramme(): ?Programme
    {
        return $this->programme;
    }

    public function setProgramme(?Programme $programme): static
    {
        $this->programme = $programme;
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
            $seanceExercice->setSeance($this);
        }
        return $this;
    }

    public function removeSeanceExercice(SeanceExercice $seanceExercice): static
    {
        if ($this->seanceExercices->removeElement($seanceExercice)) {
            if ($seanceExercice->getSeance() === $this) {
                $seanceExercice->setSeance(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Entrainement>
     */
    public function getEntrainements(): Collection
    {
        return $this->entrainements;
    }

    public function addEntrainement(Entrainement $entrainement): static
    {
        if (!$this->entrainements->contains($entrainement)) {
            $this->entrainements->add($entrainement);
            $entrainement->setSeance($this);
        }
        return $this;
    }

    public function removeEntrainement(Entrainement $entrainement): static
    {
        if ($this->entrainements->removeElement($entrainement)) {
            if ($entrainement->getSeance() === $this) {
                $entrainement->setSeance(null);
            }
        }
        return $this;
    }
}