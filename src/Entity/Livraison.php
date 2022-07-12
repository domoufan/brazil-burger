<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
#[ApiResource(
    attributes:
    [
        'pagination_enable'=>true,
        'pagination_items_per_page'=>3,

    ],
    normalizationContext:
    [
        "groups"=>['livraison:read']
    ],
    denormalizationContext:
    [
        "groups"=>['livraison:write']
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
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(['livraison:read'])]
    private $numLiv = 12345;// A AUTO GENERER

    #[ORM\Column(type: 'time', nullable: true)]
    #[Groups(['livraison:read'])]
    private $delaiLiv;

    #[ORM\Column(type: 'date')]
    #[Groups(['livraison:read'])]
    private $dateLiv;

    #[ORM\OneToMany(mappedBy: 'livraison', targetEntity: Commande::class)]
    #[Groups(['livraison:read','livraison:write'])]
     //#[ApiSubresource()]
    private $commandes;

    #[ORM\ManyToOne(targetEntity: Livreur::class, inversedBy: 'livraisons')]
    #[Groups(['livraison:read','livraison:write'])]
     //#[ApiSubresource()]
    private $livreur;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'livraisons')]
    #[Groups(['livraison:read','livraison:write'])]
    private $zone;

    public function __construct()
    {
        $this->dateLiv = new DateTime('now');
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumLiv(): ?int
    {
        return $this->numLiv;
    }

    public function setNumLiv(int $numLiv): self
    {
        $this->numLiv = $numLiv;

        return $this;
    }

    public function getDelaiLiv(): ?\DateTimeInterface
    {
        return $this->delaiLiv;
    }

    public function setDelaiLiv(?\DateTimeInterface $delaiLiv): self
    {
        $this->delaiLiv = $delaiLiv;

        return $this;
    }

    public function getDateLiv(): ?\DateTimeInterface
    {
        return $this->dateLiv;
    }

    public function setDateLiv(\DateTimeInterface $dateLiv): self
    {
        $this->dateLiv = $dateLiv;

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
            $commande->setLivraison($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getLivraison() === $this) {
                $commande->setLivraison(null);
            }
        }

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

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }
}
