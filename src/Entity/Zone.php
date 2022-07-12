<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ZoneRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ZoneRepository::class)]
#[ApiResource(
    collectionOperations:
    [
        "post",
        "get"
    ],
    itemOperations:
    [
        "put",
        "patch",
        "get"
    ],
    normalizationContext:
    [
        "groups"=>["zone:read"]
    ],
    denormalizationContext:
    [
        "groups"=>["zone:write"]
    ]
)]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'json', nullable: true)]
    #[Groups(["zone:write","zone:read"])]
    private $quartiers = [];

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(["zone:write","zone:read"])]
    private $nom;

    #[ORM\Column(type: 'float')]
    #[Groups(["zone:write","zone:read"])]
    private $prixDeLivraison;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Livraison::class)]
    private $livraisons;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'zones')]
    #[ORM\JoinColumn(nullable: false)]
    private $gestionnaire;

    public function __construct()
    {
        $this->livraisons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuartiers(): ?array
    {
        return $this->quartiers;
    }

    public function setQuartiers(?array $quartiers): self
    {
        $this->quartiers = $quartiers;

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

    public function getPrixDeLivraison(): ?float
    {
        return $this->prixDeLivraison;
    }

    public function setPrixDeLivraison(float $prixDeLivraison): self
    {
        $this->prixDeLivraison = $prixDeLivraison;

        return $this;
    }

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons[] = $livraison;
            $livraison->setZone($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getZone() === $this) {
                $livraison->setZone(null);
            }
        }

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
}
