<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreurRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
#[ApiResource()]

#[ORM\Entity(repositoryClass: LivreurRepository::class)]
class Livreur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
 private $id;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(["read","write"])]
    private $nom;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(["read","write"])]
    private $prenom;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(["read","write"])]
    private $adresse;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(["read","write"])]
    private $mat_moto;

    #[ORM\Column(type: 'integer')]
    private $etat;
    
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

    public function getMatMoto(): ?string
    {
        return $this->mat_moto;
    }

    public function setMatMoto(string $mat_moto): self
    {
        $this->mat_moto = $mat_moto;

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
}
