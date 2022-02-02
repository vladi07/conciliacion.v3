<?php

namespace App\Entity;

use App\Repository\ActividadRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActividadRepository::class)]
class Actividad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 250)]
    private $descripcion;

    #[ORM\Column(type: 'date', nullable: true)]
    private $fecha;

    #[ORM\ManyToOne(targetEntity: centro::class, inversedBy: 'actividad')]
    private $centro;

    public function __toString()
    {
        return $this->descripcion . ' ' . $this->fecha;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

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

    public function getCentro(): ?centro
    {
        return $this->centro;
    }

    public function setCentro(?centro $centro): self
    {
        $this->centro = $centro;

        return $this;
    }
}
