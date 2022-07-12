<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Date as date;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    attributes:
    [
        'pagination_enable'=>true,
        'pagination_items_per_page'=>3,

    ],
    itemOperations:
    [
        "get",
        "patch",
        "put",
    ],
        normalizationContext:
    [
        "groups"=>['commande:read']

    ],
    denormalizationContext:
    [
        "groups"=>['commande:write']
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
    #[Groups(['commande:read'])]
    private $dateCommande;


    #[ORM\Column(type: 'boolean')]

    #[Groups(['commande:read'])]
    private $isCommande = true;

    #[ORM\Column(type: 'boolean')]

    #[Groups(['commande:read'])]
    private $isPayer = false;


    #[Groups(['commande:read'])]
    private $prixComm;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
     //#[ApiSubresource()]
    private $client;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commandes')]
    #[Groups(['commande:read'])]
     //#[ApiSubresource()]
   
    private $gestionnaire;


    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    #[Groups(['commande:read'])]
     //#[ApiSubresource()]
    private $livraison;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeMenu::class ,cascade:['persist'])]
    #[Groups(['commande:read','commande:write'])]
    #[SerializedName('menus')]
    private $commandeMenus;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeProduit::class ,cascade:['persist'])]
    #[Groups(['commande:read','commande:write'])]
    #[SerializedName('produits')]
    private $commandeProduits;

    
    public function __construct()
    {
        $this->dateCommande = new DateTime();
        $this->commandeMenus = new ArrayCollection();
        $this->commandeProduits = new ArrayCollection();
    }

    #[Groups(['commande:read'])]

    public function getPrixComm()
    {
       /*  $prod = array_reduce($this->produits->toArray(),function($total){return $total;});
        $men = array_reduce($this->menus->toArray(),function($total,){return $total;});
        return $prod + $men; */
    }
    public function getId(): ?int
    {
        return $this->id;
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

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

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
            $commandeMenu->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeMenu(CommandeMenu $commandeMenu): self
    {
        if ($this->commandeMenus->removeElement($commandeMenu)) {
            // set the owning side to null (unless already changed)
            if ($commandeMenu->getCommande() === $this) {
                $commandeMenu->setCommande(null);
            }
        }

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
            $commandeProduit->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeProduit(CommandeProduit $commandeProduit): self
    {
        if ($this->commandeProduits->removeElement($commandeProduit)) {
            // set the owning side to null (unless already changed)
            if ($commandeProduit->getCommande() === $this) {
                $commandeProduit->setCommande(null);
            }
        }

        return $this;
    }


    /**
     * Get the value of dateCommande
     */ 
    public function getDateCommande()
    {
        return $this->dateCommande;
    }

    /**
     * Set the value of dateCommande
     *
     * @return  self
     */ 
    public function setDateCommande($dateCommande)
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }
}
