<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\EmailValidatorController;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "role", type: "string")]
#[ORM\DiscriminatorMap(["client" => "Client", "gestionnaire" => "Gestionnaire", "livreur"=> "Livreur"])]
#[ApiResource(
    collectionOperations:
    [
            "EMAILVALIDATE"=>[
            "method"=>"PATCH",
            "deserialize" =>false,
            "path"=>"/users/validate/{token}",
            "controller"=>EmailValidatorController::class
        ]
            ],
    itemOperations:
    [
        
    ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    #[Groups(["client:read","client:write","gestionnaire:read","gestionnaire:write","livreur:read","livreur:write"])]
    protected $email;

    #[ORM\Column(type: 'json')]
    #[Groups(["gestionnaire:read"])]
    protected $roles = ["ROLE_VISITEUR"];

    #[ORM\Column(type: 'string')]
    protected $password;

    #[Groups(["client:write","gestionnaire:write","livreur:write"])]
    #[SerializedName('password')]
    protected $plainPassword;

    #[ORM\Column(type: 'string', length: 255)]
    private $token;

    #[ORM\Column(type: 'boolean')]
    private $isEnable;

    #[ORM\Column(type: 'datetime')]
    private $expiredAt;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(["client:read","client:write","gestionnaire:read","gestionnaire:write","livreur:read","livreur:write"])]
    protected $nom;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(["client:read","client:write","gestionnaire:read","gestionnaire:write","livreur:read","livreur:write"])]
    protected $prenom;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["client:write","gestionnaire:read","gestionnaire:write","livreur:write"])]
    protected $etat;

    #[ORM\Column(type: 'string', length: 50)]
    #[Groups(["client:read","client:write","gestionnaire:read","gestionnaire:write","livreur:read","livreur:write"])]
    protected $telephone;

    public function __construct()
    {
        $this->isEnable = false;
        $this->generateTokent();
    }

    public function generateTokent(){
        $this->expiredAt = new \DateTime("+1 day");
        $this->token  = rtrim(strtr(base64_encode(random_bytes(128)),'+/','-_'),'=');
    } 

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_VISITEUR';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    /**
     * Get the value of plainPassword
     */ 
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set the value of plainPassword
     *
     * @return  self
     */ 
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function isIsEnable(): ?bool
    {
        return $this->isEnable;
    }

    public function setIsEnable(bool $isEnable): self
    {
        $this->isEnable = $isEnable;

        return $this;
    }

    public function getExpiredAt(): ?\DateTimeInterface
    {
        return $this->expiredAt;
    }

    public function setExpiredAt(\DateTimeInterface $expiredAt): self
    {
        $this->expiredAt = $expiredAt;

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function isEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }
}
