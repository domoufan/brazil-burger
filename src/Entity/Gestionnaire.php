<?php

namespace App\Entity;

use App\Entity\Menu;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GestionnaireRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Groups;

#[ApiResource(
    attributes:
    [
        "pagination_enabled" => true,
        "pagination_items_per_page" => 3,
    ],
    normalizationContext:
    [
        "groups"=>['gestionnaire:read']

    ],
    denormalizationContext:
    [
        "groups"=>['gestionnaire:write']
    ],
    collectionOperations:
    [
        "get",
        "post"
    ],
    itemOperations:
    [
        "patch",
        "put",
        "get",
    ] 
)]

#[ORM\Entity(repositoryClass: GestionnaireRepository::class)]
class Gestionnaire extends User
{
    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Menu::class)]
    #[Groups(["menu:read","menu:write"])]
    private $menu;

    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Produit::class)]
    #[Groups(["produit:read","produit:write"])]
    private $produits;

    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Livreur::class)]
    #[Groups(["livreur:read","livreur:write"])]
    private $livreurs;

    public function __construct()
    {
        parent::__construct();
        $this->menu = new ArrayCollection();
        $this->roles = ["ROLE_GESTIONNAIRE"];
        $this->produits = new ArrayCollection();
        $this->clients = new ArrayCollection();
        $this->livreurs = new ArrayCollection();
    }


    /**
     * @return Collection<int, Menu>
     */
    public function getMenu(): Collection
    {
        return $this->menu;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menu->contains($menu)) {
            $this->menu[] = $menu;
            $menu->setGestionnaire($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menu->removeElement($menu)) {
            // set the owning side to null (unless already changed)
            if ($menu->getGestionnaire() === $this) {
                $menu->setGestionnaire(null);
            }
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
            $produit->setGestionnaire($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getGestionnaire() === $this) {
                $produit->setGestionnaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Livreur>
     */
    public function getLivreurs(): Collection
    {
        return $this->livreurs;
    }

    public function addLivreur(Livreur $livreur): self
    {
        if (!$this->livreurs->contains($livreur)) {
            $this->livreurs[] = $livreur;
            $livreur->setGestionnaire($this);
        }

        return $this;
    }

    public function removeLivreur(Livreur $livreur): self
    {
        if ($this->livreurs->removeElement($livreur)) {
            // set the owning side to null (unless already changed)
            if ($livreur->getGestionnaire() === $this) {
                $livreur->setGestionnaire(null);
            }
        }

        return $this;
    }
}
