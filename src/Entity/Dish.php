<?php

namespace App\Entity;

use App\Enum\CourseNames;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DishRepository")
 */
class Dish
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
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="dishes")
     */
    private $cooked_by;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Dinner", inversedBy="dishes")
     */
    private $dinner;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $course;

    /**
     * @ORM\Column(type="boolean")
     */
    private $vegetarian;

    public function __construct()
    {
        $this->cooked_by = new ArrayCollection();
        $this->vegetarian = true;
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

    /**
     * @return Collection|User[]
     */
    public function getCookedBy(): Collection
    {
        return $this->cooked_by;
    }

    public function addCookedBy(User $cookedBy): self
    {
        if (!$this->cooked_by->contains($cookedBy)) {
            $this->cooked_by[] = $cookedBy;
        }

        return $this;
    }

    public function removeCookedBy(User $cookedBy): self
    {
        if ($this->cooked_by->contains($cookedBy)) {
            $this->cooked_by->removeElement($cookedBy);
        }

        return $this;
    }

    public function getDinner(): ?Dinner
    {
        return $this->dinner;
    }

    public function setDinner(?Dinner $dinner): self
    {
        $this->dinner = $dinner;

        return $this;
    }

    public function getCourse(): ?string
    {
        return $this->course;
    }

    public function setCourse(string $course): self
    {
        if (!in_array($course, CourseNames::getAll())) {
            throw new \InvalidArgumentException("Invalid course");
        }

        $this->course = $course;

        return $this;
    }

    public function getVegetarian(): bool
    {
        return $this->vegetarian;
    }

    public function setVegetarian(bool $vegetarian): self
    {
        $this->vegetarian = $vegetarian;

        return $this;
    }
}
