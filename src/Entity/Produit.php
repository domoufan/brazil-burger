<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use JMS\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ApiResource(
    attributes:
    [
        'pagination_enable'=>true,
        'pagination_items_per_page'=>3,

    ],
        normalizationContext:
    [
        "groups"=>['produit:read']

    ],
    denormalizationContext:
    [
        "groups"=>['produit:write']
    ],
    collectionOperations:
    [
        "get",
        "post"
    ],
    itemOperations:
    [
        "get"/* =>[
            "security" => "is_granted('ajouter', object)",
            "security_message" => "only gestionner can add product"
        ] */,
        "patch",
        "put"
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
    /* #[Groups(["produit:read","produit:write"])] */
    private $etat = true;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(["produit:read","produit:write"])]
    private $type;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    /* #[Groups(["produit:read","produit:write"])] */
    private $description;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    #[Groups(["produit:read"])]
    //#[ApiSubresource()]
    private $gestionnaire ;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: CommandeProduit::class)]
    private $commandeProduits;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: MenuProduit::class)]
    #[SerializedName('menus')]
    private $menuProduits;

    #[ORM\Column(type: 'string', length: 3)]
    #[Groups(["produit:read","produit:write"])]
    private $taille ;
    
    #[ORM\Column(type: 'blob', nullable: true)]
    #[Groups(["produit:read","produit:write"])]
    private $imageFile;

    #[Groups(["produit:read","produit:write"])]
    #[SerializedName('imageFile')]
    private $imageName;


    public function __construct()
    {
        $this->commandeProduits = new ArrayCollection();
        $this->menuProduits = new ArrayCollection();
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

    /**
     * @return Collection<int, CommandeProduit>
     */
    public function getCommandeProduits(): Collection
    {
        return $this->commandeProduits;
    }

    public function addCommandeProduit(CommandeProduit $commandeProduit): self
    {
        if (!$this->commandeProduits->contains($commandeProduit)) {
            $this->commandeProduits[] = $commandeProduit;
            $commandeProduit->setProduit($this);
        }

        return $this;
    }

    public function removeCommandeProduit(CommandeProduit $commandeProduit): self
    {
        if ($this->commandeProduits->removeElement($commandeProduit)) {
            // set the owning side to null (unless already changed)
            if ($commandeProduit->getProduit() === $this) {
                $commandeProduit->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuProduit>
     */
    public function getMenuProduits(): Collection
    {
        return $this->menuProduits;
    }

    public function addMenuProduit(MenuProduit $menuProduit): self
    {
        if (!$this->menuProduits->contains($menuProduit)) {
            $this->menuProduits[] = $menuProduit;
            $menuProduit->setProduit($this);
        }

        return $this;
    }

    public function removeMenuProduit(MenuProduit $menuProduit): self
    {
        if ($this->menuProduits->removeElement($menuProduit)) {
            // set the owning side to null (unless already changed)
            if ($menuProduit->getProduit() === $this) {
                $menuProduit->setProduit(null);
            }
        }

        return $this;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getImageName()
    {
        return $this->imageName;
    }

    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageFile($imageFile): self
    {
        $this->imageFile = $imageFile;

        return $this;
    }


}
