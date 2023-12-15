<?php

declare(strict_types=1);

namespace app\Entity;

use app\Repository\LineasPedidosRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: LineasPedidosRepository::class)]
#[Table(name: 'lineaspedidos')]
class LineasPedidosEntity
{
    #[Id]
    #[GeneratedValue]
    #[Column(name: 'idlinea', type: 'integer')]
    private int $idLinea;

    #[column(name:'cantidad', type:'decimal', precision:8, scale:2)]
    private float $cantidad;
    
    #[Column(name: 'entregado', type: Types::BOOLEAN, options:['default'=>false])]
    private bool $entregado=false;

    //Muchas lineas de pedido tienen un pedido (bidireccional)
    #[ManyToOne(targetEntity: PedidosEntity::class, inversedBy: 'lineasPedido')]
    #[JoinColumn(name: 'idPedido', referencedColumnName: 'idPedido')]
    private PedidosEntity $pedido;

    //Muchas lineas de pedido tienen un producto (unidireccional)
    #[ManyToOne(targetEntity: ProductosEntity::class)]
    #[JoinColumn(name: 'idProducto', referencedColumnName: 'idProducto')]
    private ProductosEntity $producto;

    
    /**
     * Get the value of idLinea
     */
    public function getIdLinea(): int
    {
        return $this->idLinea;
    }

    /**
     * Get the value of cantidad
     */
    public function getCantidad(): float
    {
        return $this->cantidad;
    }

    /**
     * Set the value of cantidad
     */
    public function setCantidad(float $cantidad): void
    {
        $this->cantidad = $cantidad;
    }

    /**
     * Get the value of entregado
     */
    public function isEntregado(): bool
    {
        return $this->entregado;
    }

    /**
     * Set the value of entregado
     */
    public function setEntregado(bool $entregado): void
    {
        $this->entregado = $entregado;
    }

    /**
     * Get the value of pedido
     */
    public function getPedido(): PedidosEntity
    {
        return $this->pedido;
    }

    /**
     * Set the value of pedido
     */
    public function setPedido(PedidosEntity $pedido): void
    {
        $this->pedido = $pedido;
    }

    /**
     * Get the value of producto
     */
    public function getProducto(): ProductosEntity
    {
        return $this->producto;
    }

    /**
     * Set the value of producto
     */
    public function setProducto(ProductosEntity $producto): void
    {
        $this->producto = $producto;
    }
}
