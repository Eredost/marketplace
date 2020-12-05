<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
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
     *      minMessage = "Votre nom de produit doit comporter {{ limit }} caractères minimum",
     *      maxMessage = "Votre nom de produit doit comporter {{ limit }} caractères maximum",
     *      allowEmptyString = false
     * ) 
     * 
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @Assert\NotBlank
     * @Assert\Positive
     * @Assert\LessThan(1000000)
     *
     * @ORM\Column(type="decimal", precision=8, scale=2)
     */
    private $price;

    /**
     * @Assert\NotBlank 
     * @Assert\Positive 
     * 
     * @ORM\Column(type="integer")
     */
    private $weight;

    /**
     * @Assert\NotBlank 
     * @Assert\PositiveOrZero
     * 
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @Assert\Length(
     *     max = 800,
     *     maxMessage = "La description ne peut pas dépasser {{ limit }} caractères"
     * )
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @Assert\Length(
     *     max = 400,
     *     maxMessage = "La composition ne peut pas dépasser {{ limit }} caractères"
     * )
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $composition;

    /**
     * @Assert\Length(
     *     max = 400,
     *     maxMessage = "La description additionnelle ne peut pas dépasser {{ limit }} caractères"
     * )
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $additionalInfo;

    /**
     * @Assert\Length(
     *     max = 400,
     *     maxMessage = "La liste des allergènes ne peut pas dépasser {{ limit }} caractères"
     * )
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $allergens;

    /**
     * @Assert\NotBlank 
     * @Assert\PositiveOrZero
     * 
     * @ORM\Column(type="integer")
     */
    private $rate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enable;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\Producer", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $producer;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Subcategory", inversedBy="products")
     */
    private $subcategories;

    public function __construct()
    {
        $this->rate          = 0;
        $this->enable        = true;
        $this->createdAt     = new \DateTime();
        $this->updatedAt     = null;
        $this->subcategories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

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

    public function getComposition(): ?string
    {
        return $this->composition;
    }

    public function setComposition(?string $composition): self
    {
        $this->composition = $composition;

        return $this;
    }

    public function getAdditionalInfo(): ?string
    {
        return $this->additionalInfo;
    }

    public function setAdditionalInfo(?string $additionalInfo): self
    {
        $this->additionalInfo = $additionalInfo;

        return $this;
    }

    public function getAllergens(): ?string
    {
        return $this->allergens;
    }

    public function setAllergens(?string $allergens): self
    {
        $this->allergens = $allergens;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(int $rate): self
    {
        $this->rate = $rate;

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

    public function getProducer(): ?Producer
    {
        return $this->producer;
    }

    public function setProducer(?Producer $producer): self
    {
        $this->producer = $producer;

        return $this;
    }

    /**
     * @return Collection|Subcategory[]
     */
    public function getSubcategories(): Collection
    {
        return $this->subcategories;
    }

    public function addSubcategory(Subcategory $subcategory): self
    {
        if (!$this->subcategories->contains($subcategory)) {
            $this->subcategories[] = $subcategory;
        }

        return $this;
    }

    public function removeSubcategory(Subcategory $subcategory): self
    {
        if ($this->subcategories->contains($subcategory)) {
            $this->subcategories->removeElement($subcategory);
        }

        return $this;
    }
}
