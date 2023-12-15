<?php

declare(strict_types=1);

namespace app\Entity;

use app\Repository\LineasComandasRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: LineasComandasRepository::class)]
#[Table(name: 'lineascomandas')]
class LineasComandasEntity
{
    #[Id]
    #[GeneratedValue]
    #[Column(name: 'idlinea', type: 'integer')]
    private int $idLinea;

    //Muchas lineas de comanda tienen una comanda (bidireccional)
    #[ManyToOne(targetEntity: ComandasEntity::class, inversedBy: 'lineasComanda')]
    #[JoinColumn(name: 'idComanda', referencedColumnName: 'idComanda')]
    private ComandasEntity $comanda;

    //Muchas lineas de comanda tinen un producto (unidireccional)
    #[ManyToOne(targetEntity: ProductosEntity::class)]
    #[JoinColumn(name: 'idProducto', referencedColumnName: 'idProducto')]
    private ProductosEntity $producto;

    #[column(name: 'cantidad', type: 'decimal', precision: 8, scale: 2)]
    private float $cantidad;

    #[Column(name: 'entregado', type: Types::BOOLEAN, options:['default'=>false])]
    private bool $entregado=false;

    /**
     * Get the value of idLinea
     */
    public function getIdLinea(): int
    {
        return $this->idLinea;
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
}
