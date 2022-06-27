<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreurRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
#[ApiResource(
    attributes:
    [
        "pagination_enabled" => true,
        "pagination_items_per_page" => 3,
    ],
    normalizationContext:
    [
        "groups"=>["livreur:read"]

    ],
    denormalizationContext:
    [
        "groups"=>["livreur:write"]
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

#[ORM\Entity(repositoryClass: LivreurRepository::class)]
class Livreur extends User
{
    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(["livreur:read","livreur:write"])]
    private $adresse;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(["livreur:read","livreur:write"])]
    private $matMoto;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'livreurs')]
    #[Groups(["livreur:read"])]
    private $gestionnaire;

    public function __construct()
    {
        parent::__construct();
        $this->roles = ["ROLE_LIVREUR"];
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getMatMoto(): ?string
    {
        return $this->matMoto;
    }

    public function setMatMoto(string $matMoto): self
    {
        $this->matMoto = $matMoto;

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
