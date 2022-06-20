<?php

namespace App\Entity;

use App\Repository\SalaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalaRepository::class)]
class Sala
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 200)]
    private $nombre;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $fecha_creacion;

    #[ORM\Column(type: 'string', length: 250)]
    private $actividad;

    #[ORM\Column(type: 'date', nullable: true)]
    private $fecha;

    #[ORM\ManyToOne(targetEntity: Centro::class, inversedBy: 'sala')]
    #[ORM\JoinColumn(nullable: false)]
    private $centro;

    #[ORM\OneToMany(mappedBy: 'sala', targetEntity: casoConciliatorio::class)]
    private $casoConciliatorio;

    public function __construct()
    {
        //$this->caso_conciliatorio = new ArrayCollection();
        //$this->agenda = new ArrayCollection();
        $this->casoConciliatorio = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nombre;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion(?\DateTimeInterface $fecha_creacion): self
    {
        $this->fecha_creacion = $fecha_creacion;

        return $this;
    }

    public function getActividad(): ?string
    {
        return $this->actividad;
    }

    public function setActividad(string $actividad): self
    {
        $this->actividad = $actividad;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(?\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getCentro(): ?Centro
    {
        return $this->centro;
    }

    public function setCentro(?Centro $centro): self
    {
        $this->centro = $centro;

        return $this;
    }

    /**
     * @return Collection<int, casoConciliatorio>
     */
    public function getCasoConciliatorio(): Collection
    {
        return $this->casoConciliatorio;
    }

    public function addCasoConciliatorio(casoConciliatorio $casoConciliatorio): self
    {
        if (!$this->casoConciliatorio->contains($casoConciliatorio)) {
            $this->casoConciliatorio[] = $casoConciliatorio;
            $casoConciliatorio->setSala($this);
        }

        return $this;
    }

    public function removeCasoConciliatorio(casoConciliatorio $casoConciliatorio): self
    {
        if ($this->casoConciliatorio->removeElement($casoConciliatorio)) {
            // set the owning side to null (unless already changed)
            if ($casoConciliatorio->getSala() === $this) {
                $casoConciliatorio->setSala(null);
            }
        }

        return $this;
    }

}
