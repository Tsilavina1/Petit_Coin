<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $no;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $rue;

    /**
     * @ORM\OneToMany(targetEntity=Coordonnees::class, mappedBy="address")
     */
    private $fk_coord;

    /**
     * @ORM\ManyToMany(targetEntity=Ville::class, mappedBy="fk_address")
     */
    private $villes;

    public function __construct()
    {
        $this->fk_coord = new ArrayCollection();
        $this->villes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNo(): ?int
    {
        return $this->no;
    }

    public function setNo(int $no): self
    {
        $this->no = $no;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;

        return $this;
    }

    /**
     * @return Collection|coordonnees[]
     */
    public function getFkCoord(): Collection
    {
        return $this->fk_coord;
    }

    public function addFkCoord(coordonnees $fkCoord): self
    {
        if (!$this->fk_coord->contains($fkCoord)) {
            $this->fk_coord[] = $fkCoord;
            $fkCoord->setAddress($this);
        }

        return $this;
    }

    public function removeFkCoord(coordonnees $fkCoord): self
    {
        if ($this->fk_coord->removeElement($fkCoord)) {
            // set the owning side to null (unless already changed)
            if ($fkCoord->getAddress() === $this) {
                $fkCoord->setAddress(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ville[]
     */
    public function getVilles(): Collection
    {
        return $this->villes;
    }

    public function addVille(Ville $ville): self
    {
        if (!$this->villes->contains($ville)) {
            $this->villes[] = $ville;
            $ville->addFkAddress($this);
        }

        return $this;
    }

    public function removeVille(Ville $ville): self
    {
        if ($this->villes->removeElement($ville)) {
            $ville->removeFkAddress($this);
        }

        return $this;
    }
}
