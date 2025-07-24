<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use App\Repository\EntrainementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EntrainementRepository::class)]
#[ORM\Table(name: 'entrainements')]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Delete()
    ],
    normalizationContext: ['groups' => ['entrainement:read']],
    denormalizationContext: ['groups' => ['entrainement:write']],
)]
class Entrainement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['entrainement:read', 'utilisateur:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotNull]
    #[Groups(['entrainement:read', 'entrainement:write', 'utilisateur:read'])]
    private ?\DateTimeInterface $dateEntrainement = null;

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    #[Groups(['entrainement:read', 'entrainement:write'])]
    private ?int $dureeMinutes = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(['entrainement:read', 'entrainement:write'])]
    private ?string $notesEntrainement = null;

    #[ORM\ManyToOne(inversedBy: 'entrainements')]
    #[Groups(['entrainement:read', 'entrainement:write'])]
    private ?Seance $seance = null;

    #[ORM\ManyToOne(inversedBy: 'entrainements')]
    #[Groups(['entrainement:read', 'entrainement:write'])]
    private ?Programme $programme = null;

    #[ORM\ManyToOne(inversedBy: 'entrainements')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['entrainement:read', 'entrainement:write'])]
    private ?Utilisateur $utilisateur = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['entrainement:read'])]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['entrainement:read'])]
    private ?\DateTimeInterface $dateMiseAJour = null;

    public function __construct()
    {
        $this->dateCreation = new \DateTime();
        $this->dateMiseAJour = new \DateTime();
        $this->dateEntrainement = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEntrainement(): ?\DateTimeInterface
    {
        return $this->dateEntrainement;
    }

    public function setDateEntrainement(\DateTimeInterface $dateEntrainement): static
    {
        $this->dateEntrainement = $dateEntrainement;
        $this->dateMiseAJour = new \DateTime();
        return $this;
    }

    public function getDureeMinutes(): ?int
    {
        return $this->dureeMinutes;
    }

    public function setDureeMinutes(?int $dureeMinutes): static
    {
        $this->dureeMinutes = $dureeMinutes;
        $this->dateMiseAJour = new \DateTime();
        return $this;
    }

    public function getNotesEntrainement(): ?string
    {
        return $this->notesEntrainement;
    }

    public function setNotesEntrainement(?string $notesEntrainement): static
    {
        $this->notesEntrainement = $notesEntrainement;
        $this->dateMiseAJour = new \DateTime();
        return $this;
    }

    public function getSeance(): ?Seance
    {
        return $this->seance;
    }

    public function setSeance(?Seance $seance): static
    {
        $this->seance = $seance;
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
}