<?php

namespace App\Entity;

use App\Repository\CasoConciliatorioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CasoConciliatorioRepository::class)]
class CasoConciliatorio
{
    const REGISTRO_EXITOSO = "Se ha registrado exitosamente";
    const REGISTRO_CASO_EXITOSO = "Se ha registrado el caso exitosamente";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'date')]
    private $fecha;

    #[ORM\Column(type: 'string', length: 200)]
    private $materia;

    #[ORM\Column(type: 'string', length: 100)]
    private $tipo_conciliacion;

    #[ORM\Column(type: 'text')]
    private $descripcion;

    #[ORM\Column(type: 'string', length: 200, nullable: true)]
    private $idioma;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $fecha_rechazo;

    #[ORM\Column(type: 'text', nullable: true)]
    private $motivo_rechazo;

    #[ORM\Column(type: 'string', length: 200, nullable: true)]
    private $estado;

    #[ORM\Column(type: 'string', length: 200, nullable: true)]
    private $etapa;

    #[ORM\Column(type: 'string', length: 254, nullable: true)]
    private $invitacion;

    #[ORM\Column(type: 'date', nullable: true)]
    private $fecha_audiencia;

    #[ORM\Column(type: 'time', nullable: true)]  
    private $hora_audiencia;

    #[ORM\Column(type: 'string', length: 240, nullable: true)]
    private $detalle_asistencia;

    #[ORM\Column(type: 'date', nullable: true)]
    private $fecha_asistencia;

    #[ORM\Column(type: 'string', length: 254, nullable: true)]
    private $documento;

    #[ORM\ManyToOne(targetEntity: Centro::class, inversedBy: 'caso_conciliatorio')]
    #[ORM\JoinColumn(nullable: false)]
    private $centro;

    #[ORM\ManyToMany(targetEntity: UsuarioExterno::class, inversedBy: 'caso_conciliatorio')]
    private $usuario_externo;

    #[ORM\ManyToMany(targetEntity: Usuario::class, mappedBy: 'caso_conciliatorio')]
    private $usuario;

    #[ORM\ManyToMany(targetEntity: Sala::class, inversedBy: 'caso_conciliatorio')]
    private $sala;

    #[ORM\ManyToMany(targetEntity: Agenda::class, mappedBy: 'caso_conciliatorio')]
    private $agenda;

    public function __construct()
    {
        $this->fecha = new \DateTime();
        //$this->usuario_externo = new ArrayCollection();
        $this->usuario = new ArrayCollection();
        //$this->sala = new ArrayCollection();
        //$this->agenda = new ArrayCollection();
        //$this->usuario = '';
        $this->usuario_externo = '';
        $this->sala = '';
        $this->agenda ='';
        $this->estado ='Nuevo';
        $this->invitacion = '';
        $this->fecha_audiencia = new \DateTime();
        //$this->fecha_rechazo = '';
        $this->motivo_rechazo = '';


    }

    public function __toString()
    {
        return $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getMateria(): ?string
    {
        return $this->materia;
    }

    public function setMateria(string $materia): self
    {
        $this->materia = $materia;

        return $this;
    }

    public function getTipoConciliacion(): ?string
    {
        return $this->tipo_conciliacion;
    }

    public function setTipoConciliacion(string $tipo_conciliacion): self
    {
        $this->tipo_conciliacion = $tipo_conciliacion;

        return $this;
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

    public function getIdioma(): ?string
    {
        return $this->idioma;
    }

    public function setIdioma(?string $idioma): self
    {
        $this->idioma = $idioma;

        return $this;
    }

    public function getFechaRechazo(): ?\DateTimeInterface
    {
        return $this->fecha_rechazo;
    }

    public function setFechaRechazo(?\DateTimeInterface $fecha_rechazo): self
    {
        $this->fecha_rechazo = $fecha_rechazo;

        return $this;
    }

    public function getMotivoRechazo(): ?string
    {
        return $this->motivo_rechazo;
    }

    public function setMotivoRechazo(?string $motivo_rechazo): self
    {
        $this->motivo_rechazo = $motivo_rechazo;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(?string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getEtapa(): ?string
    {
        return $this->etapa;
    }

    public function setEtapa(?string $etapa): self
    {
        $this->etapa = $etapa;

        return $this;
    }

    public function getInvitacion(): ?string
    {
        return $this->invitacion;
    }

    public function setInvitacion(?string $invitacion): self
    {
        $this->invitacion = $invitacion;

        return $this;
    }

    public function getFechaAudiencia(): ?\DateTimeInterface
    {
        return $this->fecha_audiencia;
    }

    public function setFechaAudiencia(?\DateTimeInterface $fecha_audiencia): self
    {
        $this->fecha_audiencia = $fecha_audiencia;

        return $this;
    }

    public function getHoraAudiencia(): ?\DateTimeInterface
    {
        return $this->hora_audiencia;
    }

    public function setHoraAudiencia(?\DateTimeInterface $hora_audiencia): self
    {
        $this->hora_audiencia = $hora_audiencia;

        return $this;
    }

    public function getDetalleAsistencia(): ?string
    {
        return $this->detalle_asistencia;
    }

    public function setDetalleAsistencia(?string $detalle_asistencia): self
    {
        $this->detalle_asistencia = $detalle_asistencia;

        return $this;
    }

    public function getFechaAsistencia(): ?\DateTimeInterface
    {
        return $this->fecha_asistencia;
    }

    public function setFechaAsistencia(?\DateTimeInterface $fecha_asistencia): self
    {
        $this->fecha_asistencia = $fecha_asistencia;

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
     * @return Collection|UsuarioExterno[]
     */
    public function getUsuarioExterno(): Collection
    {
        return $this->usuario_externo;
    }

    public function addUsuarioExterno(UsuarioExterno $usuarioExterno): self
    {
        if (!$this->usuario_externo->contains($usuarioExterno)) {
            $this->usuario_externo[] = $usuarioExterno;
        }

        return $this;
    }

    public function removeUsuarioExterno(UsuarioExterno $usuarioExterno): self
    {
        $this->usuario_externo->removeElement($usuarioExterno);

        return $this;
    }

    /**
     * @return Collection|Usuario[]
     */
    public function getUsuario(): Collection
    {
        return $this->usuario;
    }

    public function addUsuario(Usuario $usuario): self
    {
        if (!$this->usuario->contains($usuario)) {
            $this->usuario[] = $usuario;
            $usuario->addCasoConciliatorio($this);
        }

        return $this;
    }

    public function removeUsuario(Usuario $usuario): self
    {
        if ($this->usuario->removeElement($usuario)) {
            $usuario->removeCasoConciliatorio($this);
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
        }

        return $this;
    }

    public function removeSala(sala $sala): self
    {
        $this->sala->removeElement($sala);

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
            $agenda->addCasoConciliatorio($this);
        }

        return $this;
    }

    public function removeAgenda(Agenda $agenda): self
    {
        if ($this->agenda->removeElement($agenda)) {
            $agenda->removeCasoConciliatorio($this);
        }

        return $this;
    }
}
