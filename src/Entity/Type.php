<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeRepository::class)
 */
class Type
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Meals", mappedBy="Type")
     * @ORM\JoinColumn(nullable=false)
     */
    private $meals;

    public function __construct()
    {
        $this->meals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return Collection|Meals[]
     */
    public function getMeals(): Collection
    {
        return $this->meals;
    }

    public function addMeal(Meals $meals): self
    {
        if (!$this->meals->contains($meals)) {
            $this->meals[] = $meals;
            $meals->setType($this);
        }

        return $this;
    }

    public function removeMeal(Meals $meals): self
    {
        if ($this->meals->contains($meals)) {
            $this->meals->removeElement($meals);
            // set the owning side to null (unless already changed)
            if ($meals->getType() === $this) {
                $meals->setType(null);
            }
        }

        return $this;
    }
}
