<?php

declare(strict_types=1);

namespace app\Entity;

use app\Repository\ProductosRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: ProductosRepository::class)]
#[Table(name: 'productos')]
class ProductosEntity
{
    #[Id]
    #[GeneratedValue]
    #[Column(name: 'idProducto', type: "integer")]
    private int $idProducto;

    #[Column(name: 'nombre', type: 'string', length: 50, unique: true)]
    private string $nombre;

    #[Column(name: 'descripcion', type: 'string', length: 100, nullable: true)]
    private ?string $descripcion=null;

    #[column(name:'precio', type:'decimal', precision:6, scale:2)]
    private float $precio;


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
}
