<?php
declare(strict_types=1);
namespace app\Entity;

use DateTime;

class StockEntity {
    private int $idStock;
    private string $idProducto;
    private DateTime $fecha;
    private float $cantidad;
}