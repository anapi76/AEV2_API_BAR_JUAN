<?php
declare(strict_types=1);
namespace app\Entity;

use DateTime;

class TicketEntity {
    private int $idTicket;
    private int $idComanda;
    private DateTime $fecha;
    private float $importe;
    private bool $pagado;
    
}