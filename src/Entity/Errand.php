<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ErrandRepository")
 */
class Errand
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
     * @ORM\OneToMany(targetEntity="App\Entity\ErrandItem", mappedBy="errand")
     */
    private $errandItems;

    public function __construct()
    {
        $this->errandItems = new ArrayCollection();
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
     * @return Collection|ErrandItem[]
     */
    public function getErrandItems(): Collection
    {
        return $this->errandItems;
    }

    public function addErrandItem(ErrandItem $errandItem): self
    {
        if (!$this->errandItems->contains($errandItem)) {
            $this->errandItems[] = $errandItem;
            $errandItem->setErrand($this);
        }

        return $this;
    }

    public function removeErrandItem(ErrandItem $errandItem): self
    {
        if ($this->errandItems->contains($errandItem)) {
            $this->errandItems->removeElement($errandItem);
            // set the owning side to null (unless already changed)
            if ($errandItem->getErrand() === $this) {
                $errandItem->setErrand(null);
            }
        }

        return $this;
    }
}
