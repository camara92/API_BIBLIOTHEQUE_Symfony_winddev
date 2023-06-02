<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GenreRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: GenreRepository::class)]
  // #[UniqueEntity('libelle')]
  #[UniqueEntity(
    fields: ['libelle'],
    message: 'Il existe un genre avec le libellé {{ value }}',
)]
class Genre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('listGenreSimple', 'listGenreFull')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
   
    #[Groups('listGenreSimple', 'listGenreFull')]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Le libellé doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Le libellé doit contenir au plus  {{ limit }} caractères',
    )]
  
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'genre', targetEntity: Livre::class)]
    #[Groups('listGenreFull')]
    private Collection $livres;

    public function __construct()
    {
        $this->livres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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
            $livre->setGenre($this);
        }

        return $this;
    }

    public function removeLivre(Livre $livre): self
    {
        if ($this->livres->removeElement($livre)) {
            // set the owning side to null (unless already changed)
            if ($livre->getGenre() === $this) {
                $livre->setGenre(null);
            }
        }

        return $this;
    }
    public function tostring(){

        return $this->libelle; 
    }
}
