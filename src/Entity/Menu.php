<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    attributes:
    [
        'pagination_enable'=>true,
        'pagination_items_per_page'=>3,

    ],
    normalizationContext:
    [
        "groups"=>['menu:read']
    ],
    denormalizationContext:
    [
        "groups"=>['menu:write']
    ],
    itemOperations:
    [
        "get",
        "patch",
        "put"
    ],
    collectionOperations:
    [
        "get",
        "post"
    ]
)]

#[ApiFilter(SearchFilter::class, properties:['nom'=>'partial','type'=>'partial'])]
#[ApiFilter(NumericFilter::class, properties:['prix'])]
class Menu 
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["menu:read"])]
    private $prixmenu ;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(["menu:read","menu:write"])]
    private $nom;

    #[ORM\Column(type: 'object', nullable: true)]
    #[Groups(["menu:read","menu:write"])]
    private $image;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["menu:read","menu:write"])]
    private $etat;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'menu')]
    #[Groups(["gestionnaire:read"])]
    private $gestionnaire;


    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(["menu:read","menu:write"])]
    private $type;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["menu:read","menu:write"])]
    private $description;


    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'menus')]
    private $commandes;

    #[ORM\ManyToMany(targetEntity: Produit::class, inversedBy: 'menus')]
    #[Groups(["menu:read","menu:write"])]
    private $produits;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->produits = new ArrayCollection();
    }

    public function getPrixmenu()
    {
        return array_reduce($this->produits->toArray(),function($total,$produit){return $total + $produit->getPrix();},0);
    }

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

    public function getImage(): ?object
    {
        return $this->image;
    }

    public function setImage(?object $image): self
    {
        $this->image = $image;

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

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }



    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
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

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->addMenu($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        $this->produits->removeElement($produit);

        return $this;
    }

    
}
