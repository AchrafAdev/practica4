<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AficionesRepository")
 */
class Aficiones
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $Nombre;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Usuarios", mappedBy="Aficiones")
     */
    private $usuarios;

    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): self
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    /**
     * @return Collection|Usuarios[]
     */
    public function getUsuarios(): Collection
    {
        return $this->usuarios;
    }

    public function addUsuario(Usuarios $usuario): self
    {
        if (!$this->usuarios->contains($usuario)) {
            $this->usuarios[] = $usuario;
            $usuario->addAficione($this);
        }

        return $this;
    }

    public function removeUsuario(Usuarios $usuario): self
    {
        if ($this->usuarios->contains($usuario)) {
            $this->usuarios->removeElement($usuario);
            $usuario->removeAficione($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->Nombre;
    }
}
