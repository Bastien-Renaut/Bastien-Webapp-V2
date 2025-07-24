<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use App\Repository\ProgrammeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProgrammeRepository::class)]
#[ORM\Table(name: 'programmes')]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Delete()
    ],
    normalizationContext: ['groups' => ['programme:read']],
    denormalizationContext: ['groups' => ['programme:write']],
)]
class Programme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['programme:read', 'utilisateur:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    #[Groups(['programme:read', 'programme:write', 'utilisateur:read'])]
    private ?string $nomProgramme = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['programme:read', 'programme:write'])]
    private ?string $descriptionProgramme = null;

    #[ORM\ManyToOne(inversedBy: 'programmes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['programme:read', 'programme:write'])]
    private ?Utilisateur $utilisateur = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['programme:read'])]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['programme:read'])]
    private ?\DateTimeInterface $dateMiseAJour = null;

    #[ORM\OneToMany(mappedBy: 'programme', targetEntity: Seance::class, orphanRemoval: true)]
    #[Groups(['programme:read'])]
    private Collection $seances;

    #[ORM\OneToMany(mappedBy: 'programme', targetEntity: Entrainement::class)]
    #[Groups(['programme:read'])]
    private Collection $entrainements;

    public function __construct()
    {
        $this->seances = new ArrayCollection();
        $this->entrainements = new ArrayCollection();
        $this->dateCreation = new \DateTime();
        $this->dateMiseAJour = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProgramme(): ?string
    {
        return $this->nomProgramme;
    }

    public function setNomProgramme(string $nomProgramme): static
    {
        $this->nomProgramme = $nomProgramme;
        $this->dateMiseAJour = new \DateTime();
        return $this;
    }

    public function getDescriptionProgramme(): ?string
    {
        return $this->descriptionProgramme;
    }

    public function setDescriptionProgramme(?string $descriptionProgramme): static
    {
        $this->descriptionProgramme = $descriptionProgramme;
        $this->dateMiseAJour = new \DateTime();
        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;
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
     * @return Collection<int, Seance>
     */
    public function getSeances(): Collection
    {
        return $this->seances;
    }

    public function addSeance(Seance $seance): static
    {
        if (!$this->seances->contains($seance)) {
            $this->seances->add($seance);
            $seance->setProgramme($this);
        }
        return $this;
    }

    public function removeSeance(Seance $seance): static
    {
        if ($this->seances->removeElement($seance)) {
            if ($seance->getProgramme() === $this) {
                $seance->setProgramme(null);
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
            $entrainement->setProgramme($this);
        }
        return $this;
    }

    public function removeEntrainement(Entrainement $entrainement): static
    {
        if ($this->entrainements->removeElement($entrainement)) {
            if ($entrainement->getProgramme() === $this) {
                $entrainement->setProgramme(null);
            }
        }
        return $this;
    }
}