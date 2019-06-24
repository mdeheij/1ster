<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\VarDumper\VarDumper;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
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
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Dinner", mappedBy="going")
     */
    private $dinners;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Dish", mappedBy="cooked_by")
     */
    private $dishes;

    public function __construct()
    {
        $this->dinners = new ArrayCollection();
        $this->dishes = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getRoles(): array
    {
        return array('ROLE_USER');
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized, array('allowed_classes' => false));
    }

    /**
     * @return Collection|Dinner[]
     */
    public function getDinners(): Collection
    {
        return $this->dinners;
    }

    public function addDinner(Dinner $dinner): self
    {
        if (!$this->dinners->contains($dinner)) {
            $this->dinners[] = $dinner;
            $dinner->addGoing($this);
        }

        return $this;
    }

    public function removeDinner(Dinner $dinner): self
    {
        if ($this->dinners->contains($dinner)) {
            $this->dinners->removeElement($dinner);
            $dinner->removeGoing($this);
        }

        return $this;
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
            $dish->addCookedBy($this);
        }

        return $this;
    }

    public function removeDish(Dish $dish): self
    {
        if ($this->dishes->contains($dish)) {
            $this->dishes->removeElement($dish);
            $dish->removeCookedBy($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getName(): ?string
    {
        return $this->name ? $this->name : $this->getUsername();
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }


}
