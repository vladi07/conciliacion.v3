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

    public function __construct()
    {
        //$this->caso_conciliatorio = new ArrayCollection();
        //$this->usuario = new ArrayCollection();
        //$this->sala = new ArrayCollection();
    }

    public function __toString()
    {
        return $this -> id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
