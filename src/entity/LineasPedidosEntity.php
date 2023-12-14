<?php

declare(strict_types=1);

namespace app\Entity;

use app\Repository\LineasPedidosRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: LineasPedidosRepository::class)]
#[Table(name: 'lineaspedidos')]
class LineasPedidosEntity
{
    #[Id]
    #[GeneratedValue]
    #[Column(name: 'idlinea', type: "integer")]
    private int $idLinea;

    
    private int $idPedido;
    private int $idProducto;
    private float $cantidad;
    private bool $entregado;
}
