<?php

namespace App\Entity;

use App\Repository\TransportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransportRepository::class)]
class Transport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, article>
     */
    #[ORM\OneToMany(targetEntity: article::class, mappedBy: 'transport')]
    private Collection $name;

    public function __construct()
    {
        $this->name = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, article>
     */
    public function getName(): Collection
    {
        return $this->name;
    }

    public function addName(article $name): static
    {
        if (!$this->name->contains($name)) {
            $this->name->add($name);
            $name->setTransport($this);
        }

        return $this;
    }

    public function removeName(article $name): static
    {
        if ($this->name->removeElement($name)) {
            // set the owning side to null (unless already changed)
            if ($name->getTransport() === $this) {
                $name->setTransport(null);
            }
        }

        return $this;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
