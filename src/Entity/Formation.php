<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormationRepository::class)
 * @ORM\Table(name="formations")
 */
class Formation
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
    private $Nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $Duree;
    /**
     * @ORM\ManyToOne(targetEntity="Ecole", inversedBy="formations")
     * @ORM\JoinColumn(name="ecole_id", referencedColumnName="id")
     */
    private $ecole;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->Duree;
    }

    public function setDuree(int $Duree): self
    {
        $this->Duree = $Duree;

        return $this;
    }
    /**
     * @return Ecole|null
     */
    public function getEcole(): ?Ecole
    {
        return $this->ecole;
    }

    /**
     * @param Ecole|null $ecole
     */
    public function setEcole(?Ecole $ecole): void
    {
        $this->ecole = $ecole;
    }
    
}
