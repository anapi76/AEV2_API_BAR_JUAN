<?php
declare(strict_types=1);
namespace app\Entity;

use DateTime;

class ComandasEntity {
    private int $idComanda;
    private int $idMesa;
    private DateTime $fecha;
    private int $comensales;
    private string $detalles;
    private bool $estado;
}