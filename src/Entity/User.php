<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="Cet utilisateur existe déjà !")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas valide."
     * )
     * @Assert\Length(
     *      min = 6,
     *      max = 180,
     *      minMessage = "Votre email doit comporter {{ limit }} caractères minimum",
     *      maxMessage = "Votre email doit comporter {{ limit }} caractères maximum",
     *      allowEmptyString = false
     * )
     * 
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @Assert\NotBlank 
     * 
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @Assert\NotBlank 
     * 
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 20,
     *      minMessage = "Votre prénom doit comporter {{ limit }} caractères minimum",
     *      maxMessage = "Votre prénom doit comporter {{ limit }} caractères maximum",
     *      allowEmptyString = true
     * ) 
     * 
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $firstname;

    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 20,
     *      minMessage = "Votre nom de famille doit comporter {{ limit }} caractères minimum",
     *      maxMessage = "Votre nom de famille doit comporter {{ limit }} caractères maximum",
     *      allowEmptyString = true
     * )
     * 
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $lastname;

    /**
     * @Assert\Regex("/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/")
     * 
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $telephone;

    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 64,
     *      minMessage = "Votre adresse doit comporter {{ limit }} caractères minimum",
     *      maxMessage = "Votre adresse doit comporter {{ limit }} caractères maximum",
     *      allowEmptyString = true
     * )  
     * 
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Positive
     * @Assert\Length(
     *      min = 5,
     *      max = 5,
     *      minMessage = "Votre code postal doit comporter {{ limit }} caractères minimum",
     *      maxMessage = "Votre code postal doit comporter {{ limit }} caractères maximum",
     *      allowEmptyString = true
     * )
     */
    private $postalCode;

    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Votre ville doit comporter {{ limit }} caractères minimum",
     *      maxMessage = "Votre ville doit comporter {{ limit }} caractères maximum",
     *      allowEmptyString = true
     * ) 
     * 
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enable;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Producer", mappedBy="user", cascade={"persist", "remove"})
     */
    private $producer;

    /**
     * @Assert\NotBlank
     * @Assert\Type("\DateTime")
     * 
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @Assert\Type("\DateTime")
     * 
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function __construct()
    {
        $this->enable    = true;
        $this->createdAt = new \DateTime();
        $this->updatedAt = null;
        $this->roles     = ['ROLE_USER'];
    }

    public function __toString()
    {
        return $this->firstname . " " . $this->lastname;
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
    public function getUsername(): string
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
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->postalCode;
    }

    public function setPostalCode(?int $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getEnable(): ?bool
    {
        return $this->enable;
    }

    public function setEnable(bool $enable): self
    {
        $this->enable = $enable;

        return $this;
    }

    public function getProducer(): ?Producer
    {
        return $this->producer;
    }

    public function setProducer(Producer $producer): self
    {
        $this->producer = $producer;

        // set the owning side of the relation if necessary
        if ($this !== $producer->getUser()) {
            $producer->setUser($this);
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
