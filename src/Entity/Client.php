<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(
    attributes:
    [
        "pagination_enabled" => true,
        "pagination_items_per_page" => 3,
    ],
    normalizationContext:
    [
        "groups"=>['client:read']

    ],
    denormalizationContext:
    [
        "groups"=>['client:write']
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
class Client extends User
{
    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(["client:read","client:write"])]
    private $adresse;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'clients')]
    #[Groups(["client:read"])]
    private $gestionnaire;

    public function __construct()
    {
        parent::__construct();
        $this->roles = ["ROLE_CLIENT"];
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

}
