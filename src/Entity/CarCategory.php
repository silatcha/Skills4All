<?php

namespace App\Entity;

use App\Repository\CarCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarCategoryRepository::class)]
class CarCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'carCategory', targetEntity: Car::class)]
    private Collection $name;

    #[ORM\Column(length: 255)]
    private ?string $nameCategory = null;

    public function __construct()
    {
        $this->name = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Car>
     */
    public function getName(): Collection
    {
        return $this->name;
    }

    public function addName(Car $name): self
    {
        if (!$this->name->contains($name)) {
            $this->name->add($name);
            $name->setCarCategory($this);
        }

        return $this;
    }

    public function removeName(Car $name): self
    {
        if ($this->name->removeElement($name)) {
            // set the owning side to null (unless already changed)
            if ($name->getCarCategory() === $this) {
                $name->setCarCategory(null);
            }
        }

        return $this;
    }

    public function getNameCategory(): ?string
    {
        return $this->nameCategory;
    }

    public function setNameCategory(string $nameCategory): self
    {
        $this->nameCategory = $nameCategory;

        return $this;
    }
}
