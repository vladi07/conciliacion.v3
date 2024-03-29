<?php

namespace App\Entity;

use App\Repository\UsuarioExternoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsuarioExternoRepository::class)]
class UsuarioExterno
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 254)]
    private $nombres;

    #[ORM\Column(type: 'string', length: 250)]
    private $primer_apellido;

    #[ORM\Column(type: 'string', length: 250, nullable: true)]
    private $segundo_apellido;

    #[ORM\Column(type: 'string', length: 200)]
    private $tipo_documento;

    #[ORM\Column(type: 'bigint')]
    private $numero_documento;

    #[ORM\Column(type: 'string', length: 200)]
    private $tipo_usuario;

    #[ORM\Column(type: 'bigint')]
    private $edad;

    #[ORM\Column(type: 'string', length: 254)]
    private $domicilio;

    #[ORM\Column(type: 'string', length: 200)]
    private $genero;

    #[ORM\Column(type: 'string', length: 200, nullable: true)]
    private $grado_instruccion;

    #[ORM\Column(type: 'string', length: 240, nullable: true)]
    private $correo;

    #[ORM\Column(type: 'bigint', nullable: true)]
    private $telefono;

    #[ORM\Column(type: 'string', length: 200, nullable: true)]
    private $orden_judicial;

    #[ORM\Column(type: 'string', length: 250, nullable: true)]
    private $autoridad_emision;

    #[ORM\Column(type: 'date', nullable: true)]
    private $fecha_emision;

    #[ORM\ManyToOne(targetEntity: CasoConciliatorio::class, inversedBy: 'usuario_externo')]
    private $casoConciliatorio;


    public function __construct()
    {

    }

    public function __toString()
    {
        return $this->nombres . ' ' . $this->primer_apellido . ' ' . $this->segundo_apellido;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombres(): ?string
    {
        return $this->nombres;
    }

    public function setNombres(string $nombres): self
    {
        $this->nombres = strtoupper($nombres);

        return $this;
    }

    public function getPrimerApellido(): ?string
    {
        return $this->primer_apellido;
    }

    public function setPrimerApellido(string $primer_apellido): self
    {
        $this->primer_apellido = strtoupper($primer_apellido);

        return $this;
    }

    public function getSegundoApellido(): ?string
    {
        return $this->segundo_apellido;
    }

    public function setSegundoApellido(?string $segundo_apellido): self
    {
        $this->segundo_apellido = strtoupper($segundo_apellido);

        return $this;
    }

    public function getTipoDocumento(): ?string
    {
        return $this->tipo_documento;
    }

    public function setTipoDocumento(string $tipo_documento): self
    {
        $this->tipo_documento = $tipo_documento;

        return $this;
    }

    public function getNumeroDocumento(): ?string
    {
        return $this->numero_documento;
    }

    public function setNumeroDocumento(string $numero_documento): self
    {
        $this->numero_documento = $numero_documento;

        return $this;
    }

    public function getTipoUsuario(): ?string
    {
        return $this->tipo_usuario;
    }

    public function setTipoUsuario(string $tipo_usuario): self
    {
        $this->tipo_usuario = $tipo_usuario;

        return $this;
    }

    public function getEdad(): ?string
    {
        return $this->edad;
    }

    public function setEdad(string $edad): self
    {
        $this->edad = $edad;

        return $this;
    }

    public function getDomicilio(): ?string
    {
        return $this->domicilio;
    }

    public function setDomicilio(string $domicilio): self
    {
        $this->domicilio = strtoupper($domicilio);

        return $this;
    }

    public function getGenero(): ?string
    {
        return $this->genero;
    }

    public function setGenero(string $genero): self
    {
        $this->genero = $genero;

        return $this;
    }

    public function getGradoInstruccion(): ?string
    {
        return $this->grado_instruccion;
    }

    public function setGradoInstruccion(?string $grado_instruccion): self
    {
        $this->grado_instruccion = $grado_instruccion;

        return $this;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(?string $correo): self
    {
        $this->correo = $correo;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getOrdenJudicial(): ?string
    {
        return $this->orden_judicial;
    }

    public function setOrdenJudicial(?string $orden_judicial): self
    {
        $this->orden_judicial = $orden_judicial;

        return $this;
    }

    public function getAutoridadEmision(): ?string
    {
        return $this->autoridad_emision;
    }

    public function setAutoridadEmision(?string $autoridad_emision): self
    {
        $this->autoridad_emision = strtoupper($autoridad_emision);

        return $this;
    }

    public function getFechaEmision(): ?\DateTimeInterface
    {
        return $this->fecha_emision;
    }

    public function setFechaEmision(?\DateTimeInterface $fecha_emision): self
    {
        $this->fecha_emision = $fecha_emision;

        return $this;
    }

    public function getCasoConciliatorio(): ?CasoConciliatorio
    {
        return $this->casoConciliatorio;
    }

    public function setCasoConciliatorio(?CasoConciliatorio $casoConciliatorio): self
    {
        $this->casoConciliatorio = $casoConciliatorio;

        return $this;
    }
}
