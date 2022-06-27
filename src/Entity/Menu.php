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
        "put",
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

    #[ORM\Column(type: 'float')]
    #[Groups(["menu:read","menu:write"])]
    private $prix ;

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

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: Produit::class)]
    #[Groups(["menu:read","menu:write"])]
    private $produits;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(["menu:read","menu:write"])]
    private $type;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(["menu:read","menu:write"])]
    private $description;

    public function __construct()
    {
        $this->produits = new ArrayCollection();

    /*     foreach ($this->produits as $value) {
            var_dump($value);
        } */
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $produit->setMenu($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getMenu() === $this) {
                $produit->setMenu(null);
            }
        }

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
}
