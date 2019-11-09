<?php

namespace App\Entity;

use App\Entity\Traits\CategoryTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UniversRepository")
 */
class Univers
{
    use CategoryTrait;

    /**     
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="univers", orphanRemoval=true)
     */
    private $categories;

    public function __construct()
    {
        $this->enable     = true;
        $this->createdAt  = new \DateTime();
        $this->updatedAt  = null;
        $this->categories = new ArrayCollection();
        $this->image      = null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setUnivers($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            // set the owning side to null (unless already changed)
            if ($category->getUnivers() === $this) {
                $category->setUnivers(null);
            }
        }

        return $this;
    }
}
