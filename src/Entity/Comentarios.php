<?php

namespace App\Entity;

use App\Repository\ComentariosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ComentariosRepository::class)
 */
class Comentarios
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
    private $comentario;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha_publicacion;

    /**
     * @ORM\ManyToOne(targetEntity=Posts::class, inversedBy="comentarios")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_post;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comentarios")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_creador;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(string $comentario): self
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function getFechaPublicacion(): ?\DateTimeInterface
    {
        return $this->fecha_publicacion;
    }

    public function setFechaPublicacion(\DateTimeInterface $fecha_publicacion): self
    {
        $this->fecha_publicacion = $fecha_publicacion;

        return $this;
    }

    public function getIdPost(): ?Posts
    {
        return $this->id_post;
    }

    public function setIdPost(?Posts $id_post): self
    {
        $this->id_post = $id_post;

        return $this;
    }

    public function getIdCreador(): ?User
    {
        return $this->id_creador;
    }

    public function setIdCreador(?User $id_creador): self
    {
        $this->id_creador = $id_creador;

        return $this;
    }
}
