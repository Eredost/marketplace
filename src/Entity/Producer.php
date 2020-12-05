<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProducerRepository")
 */
class Producer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 64,
     *      minMessage = "Votre nom de raison sociale doit comporter {{ limit }} caractères minimum",
     *      maxMessage = "Votre nom de raison sociale doit comporter {{ limit }} caractères maximum",
     *      allowEmptyString = false
     * ) 
     * 
     * @ORM\Column(type="string", length=64)
     */
    private $socialReason;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "Votre numéro de siret doit comporter {{ limit }} caractères minimum",
     *      maxMessage = "Votre numéro de siret doit comporter {{ limit }} caractères maximum",
     *      allowEmptyString = false
     * )
     * 
     * @ORM\Column(type="string")
     */
    private $siretNumber;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 64,
     *      minMessage = "Votre adresse doit comporter {{ limit }} caractères minimum",
     *      maxMessage = "Votre adresse doit comporter {{ limit }} caractères maximum",
     *      allowEmptyString = false
     * )
     * 
     * @ORM\Column(type="string", length=64)
     */
    private $address;

    /**
     * 
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 5,
     *      max = 5,
     *      minMessage = "Votre code postal doit comporter {{ limit }} caractères minimum",
     *      maxMessage = "Votre code postal doit comporter {{ limit }} caractères maximum",
     *      allowEmptyString = false
     * )
     *
     * @ORM\Column(type="string", length=5)
     */
    private $postalCode;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      max = 90,
     *      maxMessage = "Votre nom de ville doit comporter {{ limit }} caractères maximum",
     *      allowEmptyString = false
     * )
     * 
     * @ORM\Column(type="string", length=50)
     */
    private $city;

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
     * @ORM\Column(type="string", length=180)
     */
    private $email;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 20,
     *      minMessage = "Votre prénom doit comporter {{ limit }} caractères minimum",
     *      maxMessage = "Votre prénom doit comporter {{ limit }} caractères maximum",
     *      allowEmptyString = false
     * ) 
     * 
     * @ORM\Column(type="string", length=20)
     */
    private $firstname;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 20,
     *      minMessage = "Votre nom de famille doit comporter {{ limit }} caractères minimum",
     *      maxMessage = "Votre nom de famille doit comporter {{ limit }} caractères maximum",
     *      allowEmptyString = false
     * )
     * 
     * @ORM\Column(type="string", length=20)
     */
    private $lastname;

    /**
     * @Assert\NotBlank
     * @Assert\Regex("/^(?:(?:\+|00)33[\s.-]{0,3}(?:\(0\)[\s.-]{0,3})?|0)[1-9](?:(?:[\s.-]?\d{2}){4}|\d{2}(?:[\s.-]?\d{3}){2})$/")
     * @Assert\Length(
     *      min = 2,
     *      max = 21,
     *      minMessage = "Votre numéro de téléphone doit comporter {{ limit }} caractères minimum",
     *      maxMessage = "Votre numéro de téléphone doit comporter {{ limit }} caractères maximum",
     *      allowEmptyString = false
     * ) 
     * 
     * @ORM\Column(type="string", length=21)
     */
    private $telephone;

    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 64,
     *      minMessage = "Votre statut doit comporter {{ limit }} caractères minimum",
     *      maxMessage = "Votre statut doit comporter {{ limit }} caractères maximum",
     *      allowEmptyString = true
     * ) 
     * 
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enable;

    /** 
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

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

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="producer")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="producer", orphanRemoval=true)
     */
    private $products;

    public function __construct()
    {
        $this->enable    = false;
        $this->createdAt = new \DateTime();
        $this->updatedAt = null;
        $this->products  = new ArrayCollection();
    }
    
    public function __toString()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSocialReason(): ?string
    {
        return $this->socialReason;
    }

    public function setSocialReason(string $socialReason): self
    {
        $this->socialReason = $socialReason;

        return $this;
    }

    public function getSiretNumber(): ?string
    {
        return $this->siretNumber;
    }

    public function setSiretNumber(string $siretNumber): self
    {
        $this->siretNumber = $siretNumber;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

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

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setProducer($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getProducer() === $this) {
                $product->setProducer(null);
            }
        }

        return $this;
    }
}
