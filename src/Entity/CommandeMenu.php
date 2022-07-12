<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\MenuController;
use App\Repository\CommandeMenuRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandeMenuRepository::class)]
/* #[ApiResource(
    attributes:
    [
        'pagination_enable'=>true,
        'pagination_items_per_page'=>3,

    ],
        normalizationContext:
    [
        "groups"=>['commandem:read']

    ],
    denormalizationContext:
    [
        "groups"=>['commandem:write']
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
)] */
class CommandeMenu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'commandeMenus')]
    private $commande;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'commandeMenus')]
    #[Groups(['commande:write'])]
    private $menu;

    #[ORM\Column(type: 'integer')]
    #[Groups(['commande:write'])]
    private $quatity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getQuatity(): ?int
    {
        return $this->quatity;
    }

    public function setQuatity(int $quatity): self
    {
        $this->quatity = $quatity;

        return $this;
    }
}
