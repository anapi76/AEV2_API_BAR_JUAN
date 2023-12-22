<?php

declare(strict_types=1);

namespace app\Entity;

use app\Repository\ProductosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: ProductosRepository::class)]
#[Table(name: 'productos')]
class ProductosEntity
{
    #[Id]
    #[GeneratedValue]
    #[Column(name: 'idProducto', type: 'integer')]
    private int $idProducto;

    #[Column(name: 'nombre', type: 'string', length: 50, unique: true)]
    private string $nombre;

    #[Column(name: 'descripcion', type: 'string', length: 100, nullable: true)]
    private ?string $descripcion = null;

    #[column(name: 'precio', type: 'decimal', precision: 8, scale: 2, options: ['default' => 0.0])]
    private float $precio = 0.0;

    //Un producto tiene muchas lineas de pedidos(bidireccional)
    #[OneToMany(targetEntity: LineasPedidosEntity::class, mappedBy: 'producto')]
    private ?Collection $lineasPedido;

    //Un producto tiene muchas lineas de comanda bidireccional)
    #[OneToMany(targetEntity: LineasComandasEntity::class, mappedBy: 'producto')]
    private ?Collection $lineasComanda;

    //Un producto tiene muchos stocks(bidireccional)
    #[OneToMany(targetEntity: StockEntity::class, mappedBy: 'producto')]
    private ?Collection $stocks;

    public function __construct() {
        $this->lineasPedido = new ArrayCollection();
        $this->stocks = new ArrayCollection();
        $this->lineasComanda = new ArrayCollection();
    }

    /**
     * Get the value of idProducto
     */
    public function getIdProducto(): int
    {
        return $this->idProducto;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre(): string
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    /**
     * Get the value of descripcion
     */
    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     */
    public function setDescripcion(?string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    /**
     * Get the value of precio
     */
    public function getPrecio(): float
    {
        return $this->precio;
    }

    /**
     * Set the value of precio
     */
    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
    }

    /**
     * Get the value of lineasPedido
     */
    public function getLineasPedido(): ?Collection
    {
        return $this->lineasPedido;
    }

    /**
     * Set the value of lineasPedido
     */
    public function setLineasPedido(?Collection $lineasPedido): void
    {
        $this->lineasPedido = $lineasPedido;
    }

    /**
     * Get the value of stocks
     */
    public function getStocks(): ?Collection
    {
        return $this->stocks;
    }

    /**
     * Set the value of stocks
     */
    public function setStocks(?Collection $stocks): void
    {
        $this->stocks = $stocks;
    }

    /**
     * Get the value of lineasComanda
     */
    public function getLineasComanda(): ?Collection
    {
        return $this->lineasComanda;
    }

    /**
     * Set the value of lineasComanda
     */
    public function setLineasComanda(?Collection $lineasComanda):void
    {
        $this->lineasComanda = $lineasComanda;
    }
}
