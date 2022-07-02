<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    attributes:
    [
        'pagination_enable'=>true,
        'pagination_items_per_page'=>3,

    ],
    normalizationContext:
    [
        "groups"=>['commande:read']
    ],
    denormalizationContext:
    [
        "groups"=>['commande:write']
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
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    #[Groups(['commande:read','commande:write'])]
    private $dateCommande;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['commande:read','commande:write'])]
    private $isCommande;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['commande:read','commande:write'])]
    private $isPayer;


    #[Groups(['commande:read'])]
    private $prixComm;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    #[Groups(['commande:read','commande:write'])]
    private $client;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commandes')]
    #[Groups(['commande:read'])]
    private $gestionnaire;

    #[ORM\ManyToMany(targetEntity: Menu::class, inversedBy: 'commandes')]
    #[Groups(['commande:read','commande:write'])]
    private $menus;

    #[ORM\ManyToMany(targetEntity: Produit::class, inversedBy: 'commandes')]
    #[Groups(['commande:read','commande:write'])]
    private $produits;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'commandes')]
    #[Groups(['commande:read','commande:write'])]
    private $zone;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    #[Groups(['commande:read'])]
    private $livraison;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
        $this->produits = new ArrayCollection();
    }
    #[Groups(['commande:read'])]

    public function getPrixComm()
    {
        $prod = array_reduce($this->produits->toArray(),function($total,$produit){return $total + $produit->getPrix();});
        $men = array_reduce($this->menus->toArray(),function($total,$menu){return $total + $menu->getPrixmenu();});
        return $prod + $men + $this->zone->getPrixDeLivraison();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }



    public function isIsCommande(): ?bool
    {
        return $this->isCommande;
    }

    public function setIsCommande(bool $isCommande): self
    {
        $this->isCommande = $isCommande;

        return $this;
    }

    public function isIsPayer(): ?bool
    {
        return $this->isPayer;
    }

    public function setIsPayer(bool $isPayer): self
    {
        $this->isPayer = $isPayer;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

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

    public function getLivreur(): ?Livreur
    {
        return $this->livreur;
    }

    public function setLivreur(?Livreur $livreur): self
    {
        $this->livreur = $livreur;

        return $this;
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        $this->menus->removeElement($menu);

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

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }
}
