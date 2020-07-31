<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 * @ApiResource
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"post:read","comment:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:read")
     */
    private $nom_poisson;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:read")
     */
    private $photo_poisson;

    /**
     * @ORM\Column(type="string")
     * @Groups("post:read")
     */
    private $taille_poisson;

    /**
     * @ORM\Column(type="string")
     * @Groups("post:read")
     */
    private $poids_poisson;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups("post:read")
     */
    private $details;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:read")
     */
    private $nom_auteur_p;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("post:read")
     */
    private $prenom_auteur_p;

    /**
     * @ORM\Column(type="datetime")
     * @Groups("post:read")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="post_id")
     * @Groups({"post:read"})
     */
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPoisson(): ?string
    {
        return $this->nom_poisson;
    }

    public function setNomPoisson(string $nom_poisson): self
    {
        $this->nom_poisson = $nom_poisson;

        return $this;
    }

    public function getPhotoPoisson(): ?string
    {
        return $this->photo_poisson;
    }

    public function setPhotoPoisson(string $photo_poisson): self
    {
        $this->photo_poisson = $photo_poisson;

        return $this;
    }

    public function getTaillePoisson(): ?int
    {
        return $this->taille_poisson;
    }

    public function setTaillePoisson(int $taille_poisson): self
    {
        $this->taille_poisson = $taille_poisson;

        return $this;
    }

    public function getPoidsPoisson(): ?int
    {
        return $this->poids_poisson;
    }

    public function setPoidsPoisson(int $poids_poisson): self
    {
        $this->poids_poisson = $poids_poisson;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getNomAuteurP(): ?string
    {
        return $this->nom_auteur_p;
    }

    public function setNomAuteurP(string $nom_auteur_p): self
    {
        $this->nom_auteur_p = $nom_auteur_p;

        return $this;
    }

    public function getPrenomAuteurP(): ?string
    {
        return $this->prenom_auteur_p;
    }

    public function setPrenomAuteurP(string $prenom_auteur_p): self
    {
        $this->prenom_auteur_p = $prenom_auteur_p;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setPostId($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getPostId() === $this) {
                $comment->setPostId(null);
            }
        }

        return $this;
    }
}
