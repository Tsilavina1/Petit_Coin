<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $icone;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="categorie")
     */
    private $fk_annonce;

    public function __construct()
    {
        $this->fk_annonce = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getIcone(): ?string
    {
        return $this->icone;
    }

    public function setIcone(string $icone): self
    {
        $this->icone = $icone;

        return $this;
    }

    /**
     * @return Collection|annonce[]
     */
    public function getFkAnnonce(): Collection
    {
        return $this->fk_annonce;
    }

    public function addFkAnnonce(annonce $fkAnnonce): self
    {
        if (!$this->fk_annonce->contains($fkAnnonce)) {
            $this->fk_annonce[] = $fkAnnonce;
            $fkAnnonce->setCategorie($this);
        }

        return $this;
    }

    public function removeFkAnnonce(annonce $fkAnnonce): self
    {
        if ($this->fk_annonce->removeElement($fkAnnonce)) {
            // set the owning side to null (unless already changed)
            if ($fkAnnonce->getCategorie() === $this) {
                $fkAnnonce->setCategorie(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->titre;
    }
}
