<?php

namespace App\Entity;

use App\Repository\TurtlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TurtlesRepository::class)]
class Turtles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $url_img = null;

    /**
     * @var Collection<int, Users>
     */
    #[ORM\OneToMany(targetEntity: Users::class, mappedBy: 'turtles')]
    private Collection $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getUrlImg(): ?string
    {
        return $this->url_img;
    }

    public function setUrlImg(string $url_img): static
    {
        $this->url_img = $url_img;

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(Users $user): static
    {
        if (!$this->user->contains($user)) {
            $this->user->add($user);
            $user->setTurtles($this);
        }

        return $this;
    }

    public function removeUser(Users $user): static
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getTurtles() === $this) {
                $user->setTurtles(null);
            }
        }

        return $this;
    }
}
