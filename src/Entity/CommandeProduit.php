<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommandeProduitRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandeProduitRepository::class)]
/* #[ApiResource(
    attributes:
    [
        'pagination_enable'=>true,
        'pagination_items_per_page'=>3,

    ],
        normalizationContext:
    [
        "groups"=>['commandep:read']

    ],
    denormalizationContext:
    [
        "groups"=>['commandep:write']
    ],
    itemOperations:
    [
        "get",
        "patch",
        "put",
    ],
    collectionOperations:
    [
        "get",
        "post"
    ]
)] */
class CommandeProduit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'commandeProduits')]
    private $commande;

    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'commandeProduits')]
    #[Groups(['commande:write'])]
    private $produit;

    #[ORM\Column(type: 'integer')]
    #[Groups(['commande:write'])]
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
