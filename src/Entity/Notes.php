<?php

namespace App\Entity;

use App\Repository\NotesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NotesRepository::class)
 */
class Notes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $moyenne;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_notes;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="notes")
     */
    private $fk_user;

    public function __construct()
    {
        $this->fk_user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMoyenne(): ?float
    {
        return $this->moyenne;
    }

    public function setMoyenne(float $moyenne): self
    {
        $this->moyenne = $moyenne;

        return $this;
    }

    public function getNbNotes(): ?int
    {
        return $this->nb_notes;
    }

    public function setNbNotes(int $nb_notes): self
    {
        $this->nb_notes = $nb_notes;

        return $this;
    }

    /**
     * @return Collection|user[]
     */
    public function getFkUser(): Collection
    {
        return $this->fk_user;
    }

    public function addFkUser(user $fkUser): self
    {
        if (!$this->fk_user->contains($fkUser)) {
            $this->fk_user[] = $fkUser;
            $fkUser->setNotes($this);
        }

        return $this;
    }

    public function removeFkUser(user $fkUser): self
    {
        if ($this->fk_user->removeElement($fkUser)) {
            // set the owning side to null (unless already changed)
            if ($fkUser->getNotes() === $this) {
                $fkUser->setNotes(null);
            }
        }

        return $this;
    }
}
