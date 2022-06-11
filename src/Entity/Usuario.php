<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
class Usuario implements UserInterface, PasswordAuthenticatedUserInterface
{
    const REGISTRO_EXITOSO = "Se ha registrado exitosamente al Usuario";
    const MODIFICACION_EXITOSA = "Se ha modificado exitosamente los Datos del Usuario";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $username;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    //#[var string The hashed password]
    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 254)]
    private $nombres;

    #[ORM\Column(type: 'string', length: 200)]
    private $primer_apellido;

    #[ORM\Column(type: 'string', length: 200, nullable: true)]
    private $segundo_apellido;

    #[ORM\Column(type: 'string', length: 200)]
    private $tipo_documento;

    #[ORM\Column(type: 'bigint')]
    private $numero_documento;

    #[ORM\Column(type: 'string', length: 200, nullable: true)]
    private $expedido;

    #[ORM\Column(type: 'string', length: 254, nullable: true)]
    private $domicilio;

    #[ORM\Column(type: 'string', length: 200, nullable: true)]
    private $departamento;

    #[ORM\Column(type: 'date', nullable: true)]
    private $fecha_nacimiento;

    #[ORM\Column(type: 'string', length: 100)]
    private $genero;

    #[ORM\Column(type: 'string', length: 200, nullable: true)]
    private $grado_academico;

    #[ORM\Column(type: 'string', length: 250, nullable: true)]
    private $profesion;

    #[ORM\Column(type: 'bigint', nullable: true)]
    private $telefono;

    #[ORM\Column(type: 'string', length: 250, nullable: true)]
    private $correo;

    #[ORM\Column(type: 'string', length: 254, nullable: true)]
    private $foto;

    #[ORM\Column(type: 'datetime')]
    private $fecha_creacion;

    #[ORM\Column(type: 'boolean')]
    private $activo;

    #[ORM\ManyToOne(targetEntity: Centro::class, inversedBy: 'usuario')]
    #[ORM\JoinColumn(nullable: true)]
    private $centro;

    #[ORM\ManyToMany(targetEntity: CasoConciliatorio::class, inversedBy: 'usuario')]
    private $caso_conciliatorio;

    #[ORM\ManyToMany(targetEntity: Agenda::class, mappedBy: 'usuario')]
    private $agenda;

    public function __construct()
    {
        $this->fecha_creacion = new \DateTime();
        $this->caso_conciliatorio = new ArrayCollection();
        $this->agenda = new ArrayCollection();
    }

    public function __toString()
    {
        return $this-> nombres . ' ' . $this->primer_apellido . ' ' . $this->segundo_apellido;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        // $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNombres(): ?string
    {
        return $this->nombres;
    }

    public function setNombres(string $nombres): self
    {
        $this->nombres = $nombres;

        return $this;
    }

    public function getPrimerApellido(): ?string
    {
        return $this->primer_apellido;
    }

    public function setPrimerApellido(string $primer_apellido): self
    {
        $this->primer_apellido = $primer_apellido;

        return $this;
    }

    public function getSegundoApellido(): ?string
    {
        return $this->segundo_apellido;
    }

    public function setSegundoApellido(?string $segundo_apellido): self
    {
        $this->segundo_apellido = $segundo_apellido;

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

    public function getExpedido(): ?string
    {
        return $this->expedido;
    }

    public function setExpedido(?string $expedido): self
    {
        $this->expedido = $expedido;

        return $this;
    }

    public function getDomicilio(): ?string
    {
        return $this->domicilio;
    }

    public function setDomicilio(?string $domicilio): self
    {
        $this->domicilio = $domicilio;

        return $this;
    }

    public function getDepartamento(): ?string
    {
        return $this->departamento;
    }

    public function setDepartamento(?string $departamento): self
    {
        $this->departamento = $departamento;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fecha_nacimiento;
    }

    public function setFechaNacimiento(?\DateTimeInterface $fecha_nacimiento): self
    {
        $this->fecha_nacimiento = $fecha_nacimiento;

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

    public function getGradoAcademico(): ?string
    {
        return $this->grado_academico;
    }

    public function setGradoAcademico(?string $grado_academico): self
    {
        $this->grado_academico = $grado_academico;

        return $this;
    }

    public function getProfesion(): ?string
    {
        return $this->profesion;
    }

    public function setProfesion(?string $profesion): self
    {
        $this->profesion = $profesion;

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

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(?string $correo): self
    {
        $this->correo = $correo;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(?string $foto): self
    {
        $this->foto = $foto;

        return $this;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion(\DateTimeInterface $fecha_creacion): self
    {
        $this->fecha_creacion = $fecha_creacion;

        return $this;
    }

    public function getActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;

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
        }

        return $this;
    }

    public function removeCasoConciliatorio(CasoConciliatorio $casoConciliatorio): self
    {
        $this->caso_conciliatorio->removeElement($casoConciliatorio);

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
            $agenda->addUsuario($this);
        }

        return $this;
    }

    public function removeAgenda(Agenda $agenda): self
    {
        if ($this->agenda->removeElement($agenda)) {
            $agenda->removeUsuario($this);
        }

        return $this;
    }
}
