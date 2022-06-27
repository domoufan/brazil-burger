<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use Symfony\Bundle\SecurityBundle\Security\UserAuthenticator;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ApiResource(
    attributes:
    [
        'pagination_enable'=>true,
        'pagination_items_per_page'=>3,

    ],
    normalizationContext:
    [
        "groups"=>["produit:read"]
    ],
    denormalizationContext:
    [
        "groups"=>["produit:write"]
    ],
    collectionOperations:
    [
        "get",
        "post"
    ],
    itemOperations:
    [
        "get",
        "patch",
        "put",
    ]
)]
#[ApiFilter(SearchFilter::class, properties:['nom'=>'partial','type'=>'partial'])]
#[ApiFilter(NumericFilter::class, properties:['prix'])]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(["produit:read","produit:write"])]
    private $nom;

    #[ORM\Column(type: 'float')]
    #[Groups(["produit:read","produit:write"])]
    private $prix;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["produit:read","produit:write"])]
    private $etat;

    #[ORM\Column(type: 'object', nullable: true)]
    #[Groups(["produit:read","produit:write"])]
    private $image;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(["produit:read","produit:write"])]
    private $type;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["produit:read","produit:write"])]
    private $description;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    private $gestionnaire ;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'produits')]
    private $menu;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getImage(): ?object
    {
        return $this->image;
    }

    public function setImage(?object $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }
}
