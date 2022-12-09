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

    /**
     * @var string The hashed password for this user
     */
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

    #[ORM\OneToMany(mappedBy: 'usuario', targetEntity: CasoConciliatorio::class)]
    private $caso;

    #[ORM\Column(nullable: true)]
    private ?int $edad = null;

    public function __construct()
    {
        $this->fecha_creacion = new \DateTime();
        //$this->agenda = new ArrayCollection();
        //$this->caso_conciliatorio = new ArrayCollection();
        $this->caso = new ArrayCollection();
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
        $this->domicilio = strtoupper($domicilio);

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
        $this->profesion = strtoupper($profesion);

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
     * @return Collection<int, CasoConciliatorio>
     */
    public function getCaso(): Collection
    {
        return $this->caso;
    }

    public function addCaso(CasoConciliatorio $caso): self
    {
        if (!$this->caso->contains($caso)) {
            $this->caso[] = $caso;
            $caso->setUsuario($this);
        }

        return $this;
    }

    public function removeCaso(CasoConciliatorio $caso): self
    {
        if ($this->caso->removeElement($caso)) {
            // set the owning side to null (unless already changed)
            if ($caso->getUsuario() === $this) {
                $caso->setUsuario(null);
            }
        }

        return $this;
    }

    public function getEdad(): ?int
    {
        return $this->edad;
    }

    public function setEdad(?int $edad): self
    {
        $this->edad = $edad;

        return $this;
    }

}