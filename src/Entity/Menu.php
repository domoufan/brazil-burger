<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\MenuController;
use App\Repository\MenuRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use JMS\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Annotation\SerializedName as AnnotationSerializedName;

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
        "post",
        "menuPost"=>[
            "method"=>"POST",
            "path"=>"/menu2",
            "controller"=>MenuController::class,
        ]
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

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(["menu:read","menu:write"])]
    private $nom;

    #[ORM\Column(type: 'boolean')]
    private $etat = true;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'menu')]
     //#[ApiSubresource()]
    private $gestionnaire;


    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[Groups(["menu:read","menu:write"])]
    private $type;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: CommandeMenu::class)]
    private $commandeMenus;

    #[SerializedName('produits')]
    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuProduit::class  ,cascade:['persist'])]
    #[Groups(["menu:read","menu:write"])]
    private $menuProduits;

    #[ORM\Column(type: 'string', length: 3)]
    private $taille;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $imageName;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $imageFile;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $imageSize;


    public function __construct()
    {
        $this->commandeMenus = new ArrayCollection();
        $this->menuProduits = new ArrayCollection();
    }

    public function getPrixmenu()
    {
        return array_reduce($this->produits->toArray(),function($total,$produit){return ($total + $produit->getPrix());},0);
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
     * @return Collection<int, CommandeMenu>
     */
    public function getCommandeMenus(): Collection
    {
        return $this->commandeMenus;
    }

    public function addCommandeMenu(CommandeMenu $commandeMenu): self
    {
        if (!$this->commandeMenus->contains($commandeMenu)) {
            $this->commandeMenus[] = $commandeMenu;
            $commandeMenu->setMenu($this);
        }

        return $this;
    }

    public function removeCommandeMenu(CommandeMenu $commandeMenu): self
    {
        if ($this->commandeMenus->removeElement($commandeMenu)) {
            // set the owning side to null (unless already changed)
            if ($commandeMenu->getMenu() === $this) {
                $commandeMenu->setMenu(null);
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
            $menuProduit->setMenu($this);
        }

        return $this;
    }    
    
    public function addProduit(Produit $produit ,int $quantity = 1)
    {
       $menuprod = new MenuProduit();

       $menuprod->setProduit($produit);
       $menuprod->setMenu($this);
       $menuprod->setQuantity($quantity);

       $this->addMenuProduit($menuprod);
    }

    public function removeMenuProduit(MenuProduit $menuProduit): self
    {
        if ($this->menuProduits->removeElement($menuProduit)) {
            // set the owning side to null (unless already changed)
            if ($menuProduit->getMenu() === $this) {
                $menuProduit->setMenu(null);
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

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
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

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function setImageSize(?int $imageSize): self
    {
        $this->imageSize = $imageSize;

        return $this;
    }
    
}
