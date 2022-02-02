<?php

namespace App\Entity;

use App\Repository\CentroRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CentroRepository::class)]
class Centro
{
    const REGISTRO_EXITOSO = "Se ha registrado exitosamente";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 250)]
    private $nombre;

    #[ORM\Column(type: 'string', length: 254)]
    private $direccion;

    #[ORM\Column(type: 'string', length: 100)]
    private $matricula;

    #[ORM\Column(type: 'string', length: 100)]
    private $resolucion;

    #[ORM\Column(type: 'date')]
    private $vigencia;

    #[ORM\Column(type: 'string', length: 150)]
    private $tipo;

    #[ORM\Column(type: 'string', length: 250)]
    private $representante;

    #[ORM\Column(type: 'string', length: 250)]
    private $cargo_representante;

    #[ORM\Column(type: 'string', length: 200)]
    private $departamento;

    #[ORM\Column(type: 'string', length: 250)]
    private $ciudad;

    #[ORM\Column(type: 'string', length: 250, nullable: true)]
    private $zona;

    #[ORM\Column(type: 'bigint', nullable: true)]
    private $telefono;

    #[ORM\Column(type: 'bigint', nullable: true)]
    private $fax;

    #[ORM\Column(type: 'string', length: 250, nullable: true)]
    private $correo;

    #[ORM\Column(type: 'string', length: 254, nullable: true)]
    private $documento;

    #[ORM\OneToMany(mappedBy: 'centro', targetEntity: Usuario::class, orphanRemoval: true)]
    private $usuario;

    #[ORM\OneToMany(mappedBy: 'centro', targetEntity: CasoConciliatorio::class, orphanRemoval: true)]
    private $caso_conciliatorio;

    #[ORM\OneToMany(mappedBy: 'centro', targetEntity: Sala::class, orphanRemoval: true)]
    private $sala;

    #[ORM\OneToMany(mappedBy: 'centro', targetEntity: Actividad::class)]
    private $actividad;

    public function __construct()
    {
        $this->usuario = new ArrayCollection();
        $this->caso_conciliatorio = new ArrayCollection();
        $this->sala = new ArrayCollection();
        $this->actividad = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nombre . ' ' . $this->matricula;
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

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): self
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getMatricula(): ?string
    {
        return $this->matricula;
    }

    public function setMatricula(string $matricula): self
    {
        $this->matricula = $matricula;

        return $this;
    }

    public function getResolucion(): ?string
    {
        return $this->resolucion;
    }

    public function setResolucion(string $resolucion): self
    {
        $this->resolucion = $resolucion;

        return $this;
    }

    public function getVigencia(): ?\DateTimeInterface
    {
        return $this->vigencia;
    }

    public function setVigencia(\DateTimeInterface $vigencia): self
    {
        $this->vigencia = $vigencia;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getRepresentante(): ?string
    {
        return $this->representante;
    }

    public function setRepresentante(string $representante): self
    {
        $this->representante = $representante;

        return $this;
    }

    public function getCargoRepresentante(): ?string
    {
        return $this->cargo_representante;
    }

    public function setCargoRepresentante(string $cargo_representante): self
    {
        $this->cargo_representante = $cargo_representante;

        return $this;
    }

    public function getDepartamento(): ?string
    {
        return $this->departamento;
    }

    public function setDepartamento(string $departamento): self
    {
        $this->departamento = $departamento;

        return $this;
    }

    public function getCiudad(): ?string
    {
        return $this->ciudad;
    }

    public function setCiudad(string $ciudad): self
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    public function getZona(): ?string
    {
        return $this->zona;
    }

    public function setZona(?string $zona): self
    {
        $this->zona = $zona;

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

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(?string $fax): self
    {
        $this->fax = $fax;

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

    public function getDocumento(): ?string
    {
        return $this->documento;
    }

    public function setDocumento(?string $documento): self
    {
        $this->documento = $documento;

        return $this;
    }

    /**
     * @return Collection|usuario[]
     */
    public function getUsuario(): Collection
    {
        return $this->usuario;
    }

    public function addUsuario(usuario $usuario): self
    {
        if (!$this->usuario->contains($usuario)) {
            $this->usuario[] = $usuario;
            $usuario->setCentro($this);
        }

        return $this;
    }

    public function removeUsuario(usuario $usuario): self
    {
        if ($this->usuario->removeElement($usuario)) {
            // set the owning side to null (unless already changed)
            if ($usuario->getCentro() === $this) {
                $usuario->setCentro(null);
            }
        }

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
            $casoConciliatorio->setCentro($this);
        }

        return $this;
    }

    public function removeCasoConciliatorio(CasoConciliatorio $casoConciliatorio): self
    {
        if ($this->caso_conciliatorio->removeElement($casoConciliatorio)) {
            // set the owning side to null (unless already changed)
            if ($casoConciliatorio->getCentro() === $this) {
                $casoConciliatorio->setCentro(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|sala[]
     */
    public function getSala(): Collection
    {
        return $this->sala;
    }

    public function addSala(sala $sala): self
    {
        if (!$this->sala->contains($sala)) {
            $this->sala[] = $sala;
            $sala->setCentro($this);
        }

        return $this;
    }

    public function removeSala(sala $sala): self
    {
        if ($this->sala->removeElement($sala)) {
            // set the owning side to null (unless already changed)
            if ($sala->getCentro() === $this) {
                $sala->setCentro(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Actividad[]
     */
    public function getActividad(): Collection
    {
        return $this->actividad;
    }

    public function addActividad(Actividad $actividad): self
    {
        if (!$this->actividad->contains($actividad)) {
            $this->actividad[] = $actividad;
            $actividad->setCentro($this);
        }

        return $this;
    }

    public function removeActividad(Actividad $actividad): self
    {
        if ($this->actividad->removeElement($actividad)) {
            // set the owning side to null (unless already changed)
            if ($actividad->getCentro() === $this) {
                $actividad->setCentro(null);
            }
        }

        return $this;
    }
}