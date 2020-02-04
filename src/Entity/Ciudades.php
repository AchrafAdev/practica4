<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CiudadesRepository")
 */
class Ciudades
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $Nombre;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Usuarios", mappedBy="Ciudad")
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
            $usuario->setCiudad($this);
        }

        return $this;
    }

    public function removeUsuario(Usuarios $usuario): self
    {
        if ($this->usuarios->contains($usuario)) {
            $this->usuarios->removeElement($usuario);
            // set the owning side to null (unless already changed)
            if ($usuario->getCiudad() === $this) {
                $usuario->setCiudad(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->Nombre;
    }
}
