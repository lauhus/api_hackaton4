<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 * @ApiResource
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"post:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post:read"})
     */
    private $nom_auteur_c;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"post:read"})
     */
    private $prenom_auteur_c;

    /**
     * @ORM\Column(type="string" , length=400)
     * @Groups({"post:read"})
     */
    private $contenu;

    /**
     * @ORM\Column(type="date")
     * @Groups({"post:read"})
     */
    private $date_comment;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="comments")
     */
    private $post_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomAuteurC(): ?string
    {
        return $this->nom_auteur_c;
    }

    public function setNomAuteurC(string $nom_auteur_c): self
    {
        $this->nom_auteur_c = $nom_auteur_c;

        return $this;
    }

    public function getPrenomAuteurC(): ?string
    {
        return $this->prenom_auteur_c;
    }

    public function setPrenomAuteurC(string $prenom_auteur_c): self
    {
        $this->prenom_auteur_c = $prenom_auteur_c;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDateComment(): ?\DateTimeInterface
    {
        return $this->date_comment;
    }

    public function setDateComment(\DateTimeInterface $date_comment): self
    {
        $this->date_comment = $date_comment;

        return $this;
    }

    public function getPostId(): ?Post
    {
        return $this->post_id;
    }

    public function setPostId(?Post $post_id): self
    {
        $this->post_id = $post_id;

        return $this;
    }
}
