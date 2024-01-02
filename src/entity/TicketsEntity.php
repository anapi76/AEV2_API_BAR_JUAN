<?php

declare(strict_types=1);

namespace app\Entity;

use app\Repository\TicketsRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: TicketsRepository::class)]
#[Table(name: 'tickets')]
class TicketsEntity
{
    #[Id]
    #[GeneratedValue]
    #[Column(name: 'idTicket', type: 'integer')]
    private int $idTicket;

    #[ManyToOne(targetEntity: ComandasEntity::class, inversedBy:'tickets')]
    #[JoinColumn(name: 'idComanda', referencedColumnName: 'idComanda')]
    private ComandasEntity $comanda;

    #[Column(name: 'fecha', type: 'datetime')]
    private DateTime $fecha;

    #[column(name: 'importe', type: 'decimal', precision: 10, scale: 2)]
    private float $importe;

    #[Column(name: 'pagado', type: Types::BOOLEAN, options:['default'=>false])]
    private bool $pagado=false;

    /**
     * Get the value of idTicket
     */
    public function getIdTicket(): int
    {
        return $this->idTicket;
    }

    /**
     * Get the value of comanda
     */
    public function getComanda(): ComandasEntity
    {
        return $this->comanda;
    }

    /**
     * Set the value of comanda
     */
    public function setComanda(ComandasEntity $comanda): void
    {
        $this->comanda = $comanda;
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
     * Get the value of importe
     */
    public function getImporte(): float
    {
        return $this->importe;
    }

    /**
     * Set the value of importe
     */
    public function setImporte(float $importe):void
    {
        $this->importe = $importe;

    }

    /**
     * Get the value of pagado
     */
    public function isPagado(): bool
    {
        return $this->pagado;
    }

    /**
     * Set the value of pagado
     */
    public function setPagado(bool $pagado):void
    {
        $this->pagado = $pagado;
    }
}
