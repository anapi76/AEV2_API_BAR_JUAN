<?php

declare(strict_types=1);

namespace app\Entity;

use app\Repository\TicketRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: TicketRepository::class)]
#[Table(name: 'tickets')]
class TicketEntity
{
    #[Id]
    #[GeneratedValue]
    #[Column(name: 'idTicket', type: 'integer')]
    private int $idTicket;

    #[OneToOne(targetEntity: ComandasEntity::class)]
    #[JoinColumn(name: 'idComanda', referencedColumnName: 'idComanda')]
    private ComandasEntity $comanda;

    #[Column(name: 'fecha', type: Types::DATE_MUTABLE)]
    private DateTime $fecha;

    #[column(name: 'importe', type: 'decimal', precision: 10, scale: 2)]
    private float $importe;

    #[Column(name: 'pagado', type: Types::BOOLEAN, options:['default'=>false])]
    private bool $pagado=false;
}
