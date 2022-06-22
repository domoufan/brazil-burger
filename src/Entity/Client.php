<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource()]
class Client extends User
{

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(["read","write"])]
    private $nom;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(["read","write"])]
    private $prenom;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(["read","write"])]
    private $adresse;

    #[ORM\Column(type: 'integer')]
    private $etat;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(["read","write"])]
    private $tel;

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
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

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }
}
