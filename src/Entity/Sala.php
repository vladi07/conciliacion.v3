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

    #[ORM\ManyToMany(targetEntity: CasoConciliatorio::class, mappedBy: 'sala')]
    private $caso_conciliatorio;

    #[ORM\ManyToMany(targetEntity: Agenda::class, mappedBy: 'sala')]
    private $agenda;

    public function __construct()
    {
        $this->caso_conciliatorio = new ArrayCollection();
        $this->agenda = new ArrayCollection();
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
     * @return Collection|CasoConciliatorio[]
     */
    public function getCasoConciliatorio(): Collection
    {
        return $this->caso_conciliatorio;
    }

    public function addCasoConciliatorio(CasoConciliatorio $casoConciliatorio): self
    {
        if (!$this->caso_conciliatorio->contains($casoConciliatorio)) {
            $this->caso_conciliatorio[] = $casoConciliatorio;
            $casoConciliatorio->addSala($this);
        }

        return $this;
    }

    public function removeCasoConciliatorio(CasoConciliatorio $casoConciliatorio): self
    {
        if ($this->caso_conciliatorio->removeElement($casoConciliatorio)) {
            $casoConciliatorio->removeSala($this);
        }

        return $this;
    }

    /**
     * @return Collection|Agenda[]
     */
    public function getAgenda(): Collection
    {
        return $this->agenda;
    }

    public function addAgenda(Agenda $agenda): self
    {
        if (!$this->agenda->contains($agenda)) {
            $this->agenda[] = $agenda;
            $agenda->addSala($this);
        }

        return $this;
    }

    public function removeAgenda(Agenda $agenda): self
    {
        if ($this->agenda->removeElement($agenda)) {
            $agenda->removeSala($this);
        }

        return $this;
    }
}
