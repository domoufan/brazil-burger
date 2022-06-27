<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ZoneRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ZoneRepository::class)]
#[ApiResource(
    collectionOperations:
    [
        "post",
        "get"
    ],
    itemOperations:
    [
        "put",
        "patch",
        "get"
    ],
    normalizationContext:
    [
        "groups"=>["zone:read"]
    ],
    denormalizationContext:
    [
        "groups"=>["zone:write"]
    ]
)]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'array', nullable: true)]
    #[Groups(["zone:write","zone:read"])]
    private $quartiers = [];

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(["zone:write","zone:read"])]
    private $nom;

    #[ORM\Column(type: 'float')]
    #[Groups(["zone:write","zone:read"])]
    private $prixDeLivraison;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuartiers(): ?array
    {
        return $this->quartiers;
    }

    public function setQuartiers(?array $quartiers): self
    {
        $this->quartiers = $quartiers;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrixDeLivraison(): ?float
    {
        return $this->prixDeLivraison;
    }

    public function setPrixDeLivraison(float $prixDeLivraison): self
    {
        $this->prixDeLivraison = $prixDeLivraison;

        return $this;
    }
}
