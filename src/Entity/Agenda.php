<?php

namespace App\Entity;

use App\Repository\AgendaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgendaRepository::class)]
class Agenda
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToMany(targetEntity: CasoConciliatorio::class, inversedBy: 'agenda')]
    private $caso_conciliatorio;

    #[ORM\ManyToMany(targetEntity: Usuario::class, inversedBy: 'agenda')]
    private $usuario;

    #[ORM\ManyToMany(targetEntity: Sala::class, inversedBy: 'agenda')]
    private $sala;

    public function __construct()
    {
        $this->caso_conciliatorio = new ArrayCollection();
        $this->usuario = new ArrayCollection();
        $this->sala = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
        }

        return $this;
    }

    public function removeUsuario(usuario $usuario): self
    {
        $this->usuario->removeElement($usuario);

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
}
