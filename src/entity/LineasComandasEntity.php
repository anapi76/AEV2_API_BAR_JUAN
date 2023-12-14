<?php
declare(strict_types=1);
namespace app\Entity;

class LineasComandasEntity {
    private int $idLinea;
    private int $idComanda;
    private int $idProducto;
    private float $cantidad;
    private bool $entregado;
}