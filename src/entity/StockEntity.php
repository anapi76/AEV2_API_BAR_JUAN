<?php

declare(strict_types=1);

namespace app\Entity;

use app\Repository\StockRepository;
use DateTime;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: StockRepository::class)]
#[Table(name: 'stock')]
class StockEntity
{
    #[Id]
    #[GeneratedValue]
    #[Column(name: 'idStock', type: 'integer')]
    private int $idStock;

    //muchos registros stock tienen un producto (unidireccional)
    #[ManyToOne(targetEntity: ProductosEntity::class)]
    #[JoinColumn(name: 'id_producto', referencedColumnName: 'idProducto')]
    private ProductosEntity $producto;

    #[Column(name: 'fecha', type: 'datetime')]
    private DateTime $fecha;

    #[column(name: 'cantidad', type: 'decimal', precision: 8, scale: 2, options: ['default' => 0.0])]
    private float $cantidad = 0.0;

    /**
     * Get the value of idStock
     */
    public function getIdStock(): int
    {
        return $this->idStock;
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
}
