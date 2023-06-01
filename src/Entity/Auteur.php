<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AuteurRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AuteurRepository::class)]
class Auteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
  
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('listGenreFull')]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups('listGenreFull')]
    private ?string $prenom = null;

    #[ORM\ManyToOne(inversedBy: 'auteurs')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups('listGenreFull')]
    
    private ?Nationalite $nationalite = null;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: Livre::class)]
    // on ne met pas listgenrefull car il va être une référence circulaire 
    
    private Collection $livres;

    public function __construct()
    {
        $this->livres = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNationalite(): ?Nationalite
    {
        return $this->nationalite;
    }

    public function setNationalite(?Nationalite $nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * @return Collection<int, Livre>
     */
    public function getLivres(): Collection
    {
        return $this->livres;
    }

    public function addLivre(Livre $livre): self
    {
        if (!$this->livres->contains($livre)) {
            $this->livres->add($livre);
            $livre->setAuteur($this);
        }

        return $this;
    }

    public function removeLivre(Livre $livre): self
    {
        if ($this->livres->removeElement($livre)) {
            // set the owning side to null (unless already changed)
            if ($livre->getAuteur() === $this) {
                $livre->setAuteur(null);
            }
        }

        return $this;
    }

    // transformation des objets : tostring sur les entités 
    
    public function __toString(){
        return $this->nom. ' '.$this->prenom; 
    }
}
