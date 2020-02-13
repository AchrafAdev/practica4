<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


//Cambios hechos en la entity añadiendo assert para no permitir valores null en Ciudades ni fotos

/**  
 * @ORM\Entity(repositoryClass="App\Repository\UsuariosRepository")
 */
class Usuarios
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $Nombre;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $Apellidos;

    /**
     * @ORM\Column(type="date")
     */
    private $Nacimiento;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $Sexo;

    /**
     * @Assert\NotNull(message="ciu.not_null")
     * @ORM\ManyToOne(targetEntity="App\Entity\Ciudades", inversedBy="usuarios")
     */
    private $Ciudad;

    /**
     * @Assert\NotNull(message="afi.not_null")
     * @ORM\ManyToMany(targetEntity="App\Entity\Aficiones", inversedBy="usuarios")
     */
    private $Aficiones;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imagen;

    public function __construct()
    {
        $this->Aficiones = new ArrayCollection();
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

    public function getApellidos(): ?string
    {
        return $this->Apellidos;
    }

    public function setApellidos(string $Apellidos): self
    {
        $this->Apellidos = $Apellidos;

        return $this;
    }

    public function getNacimiento(): ?\DateTimeInterface
    {
        return $this->Nacimiento;
    }

    public function setNacimiento(\DateTimeInterface $Nacimiento): self
    {
        $this->Nacimiento = $Nacimiento;

        return $this;
    }

    public function getSexo(): ?string
    {
        return $this->Sexo;
    }

    public function setSexo(string $Sexo): self
    {
        $this->Sexo = $Sexo;

        return $this;
    }

    public function getCiudad(): ?Ciudades
    {
        return $this->Ciudad;
    }

    public function setCiudad(?Ciudades $Ciudad): self
    {
        $this->Ciudad = $Ciudad;

        return $this;
    }

    /**
     * @return Collection|Aficiones[]
     */
    public function getAficiones(): Collection
    {
        return $this->Aficiones;
    }

    public function addAficione(Aficiones $aficione): self
    {
        if (!$this->Aficiones->contains($aficione)) {
            $this->Aficiones[] = $aficione;
        }

        return $this;
    }

    public function removeAficione(Aficiones $aficione): self
    {
        if ($this->Aficiones->contains($aficione)) {
            $this->Aficiones->removeElement($aficione);
        }

        return $this;
    }

    public function getImagen()
    {
        return $this->imagen;
    }



    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }


}
