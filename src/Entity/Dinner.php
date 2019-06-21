<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DinnerRepository")
 */
class Dinner
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $theme;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $day;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="dinners")
     */
    private $going;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Dish", mappedBy="dinner")
     */
    private $dishes;

    public function __construct()
    {
        $this->going = new ArrayCollection();
        $this->dishes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTheme(): ?string
    {
        return $this->theme;
    }

    public function setTheme(?string $theme): self
    {
        $this->theme = $theme;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getDay(): ?\DateTimeInterface
    {
        // $this->getDay()->format('Y-m-d')
        return $this->day;
    }

    public function setDay(?\DateTimeInterface $day): self
    {
        $this->day = $day;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getGoing(): Collection
    {
        return $this->going;
    }

    public function isUserGoing(User $user): bool
    {
        return $this->going->contains($user);
    }

    public function addGoing(User $user): self
    {
        if (!$this->going->contains($user)) {
            $this->going[] = $user;
        }

        return $this;
    }

    public function removeGoing(User $user): self
    {
        if ($this->going->contains($user)) {
            $this->going->removeElement($user);
        }

        return $this;
    }

    public function __toString(): string
    {
        return sprintf('%s: %s',$this->getTheme(), $this->getLocation());
    }

    /**
     * @return Collection|Dish[]
     */
    public function getDishes(): Collection
    {
        return $this->dishes;
    }

    public function addDish(Dish $dish): self
    {
        if (!$this->dishes->contains($dish)) {
            $this->dishes[] = $dish;
            $dish->setDinner($this);
        }

        return $this;
    }

    public function removeDish(Dish $dish): self
    {
        if ($this->dishes->contains($dish)) {
            $this->dishes->removeElement($dish);
            // set the owning side to null (unless already changed)
            if ($dish->getDinner() === $this) {
                $dish->setDinner(null);
            }
        }

        return $this;
    }


}
