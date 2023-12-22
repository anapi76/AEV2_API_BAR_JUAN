<?php

declare(strict_types=1);

namespace app\Entity;

use app\Repository\ComandasRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: ComandasRepository::class)]
#[Table(name: 'comandas')]
class ComandasEntity
{
    #[Id]
    #[GeneratedValue]
    #[Column(name: 'idComanda', type: 'integer')]
    private int $idComanda;

    //Muchas comandas tienen una mesa(bidireccional)
    #[ManyToOne(targetEntity: MesaEntity::class, inversedBy: 'comandas')]
    #[JoinColumn(name: 'idMesa', referencedColumnName: 'idMesa')]
    private MesaEntity $mesa;

    #[Column(name: 'fecha', type: Types::DATE_MUTABLE)]
    private DateTime $fecha;

    #[Column(name: 'comensales', type: 'integer')]
    private int $comensales;

    #[Column(name: 'detalles', type: 'string', length: 250, nullable: true)]
    private ?string $detalles = null;

    #[Column(name: 'estado', type: Types::BOOLEAN, options: ['default' => true])]
    private bool $estado = true;

    //Una comanda tiene muchas lineas de comanda(bidireccional)
    #[OneToMany(targetEntity: LineasComandasEntity::class, mappedBy: 'comanda')]
    private ?Collection $lineasComanda;

    public function __construct()
    {
        $this->lineasComanda = new ArrayCollection();
    }

    /**
     * Get the value of idComanda
     */
    public function getIdComanda(): int
    {
        return $this->idComanda;
    }

    /**
     * Get the value of mesa
     */
    public function getMesa(): MesaEntity
    {
        return $this->mesa;
    }

    /**
     * Set the value of mesa
     */
    public function setMesa(MesaEntity $mesa): void
    {
        $this->mesa = $mesa;
    }

    /**
     * Get the value of fecha
     */
    public function getFecha(): DateTime
    {
        return $this->fecha;
    }

    /**
     * Set the value of fecha
     */
    public function setFecha(DateTime $fecha): void
    {
        $this->fecha = $fecha;
    }

    /**
     * Get the value of comensales
     */
    public function getComensales(): int
    {
        return $this->comensales;
    }

    /**
     * Set the value of comensales
     */
    public function setComensales(int $comensales): void
    {
        $this->comensales = $comensales;
    }

    /**
     * Get the value of detalles
     */
    public function getDetalles(): ?string
    {
        return $this->detalles;
    }

    /**
     * Set the value of detalles
     */
    public function setDetalles(?string $detalles): void
    {
        $this->detalles = $detalles;
    }

    /**
     * Get the value of estado
     */
    public function isEstado(): bool
    {
        return $this->estado;
    }

    /**
     * Set the value of estado
     */
    public function setEstado(bool $estado): void
    {
        $this->estado = $estado;
    }

    /**
     * Get the value of lineasComanda
     */
    public function getLineasComanda(): ?Collection
    {
        return $this->lineasComanda;
    }

    /**
     * Set the value of lineasComanda
     */
    public function setLineasComanda(?Collection $lineasComanda): void
    {
        $this->lineasComanda = $lineasComanda;
    }
}
