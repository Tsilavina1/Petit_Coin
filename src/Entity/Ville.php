<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VilleRepository::class)
 */
class Ville
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
    private $nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $departement;

    /**
     * @ORM\ManyToMany(targetEntity=Address::class, inversedBy="villes")
     */
    private $fk_address;

    /**
     * @ORM\OneToMany(targetEntity=Annonce::class, mappedBy="fk_ville")
     */
    private $annonces;

    public function __construct()
    {
        $this->fk_address = new ArrayCollection();
        $this->annonces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getCp(): ?int
    {
        return $this->cp;
    }

    public function setCp(int $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(string $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    /**
     * @return Collection|address[]
     */
    public function getFkAddress(): Collection
    {
        return $this->fk_address;
    }

    public function addFkAddress(address $fkAddress): self
    {
        if (!$this->fk_address->contains($fkAddress)) {
            $this->fk_address[] = $fkAddress;
        }

        return $this;
    }

    public function removeFkAddress(address $fkAddress): self
    {
        $this->fk_address->removeElement($fkAddress);

        return $this;
    }

    /**
     * @return Collection|Annonce[]
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setFkVille($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getFkVille() === $this) {
                $annonce->setFkVille(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->nom;
    }
}
