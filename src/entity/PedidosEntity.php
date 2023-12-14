<?php
declare(strict_types=1);
namespace app\Entity;

use app\Repository\PedidosRepository;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: PedidosRepository::class)]
#[Table(name: 'pedidos')]
class PedidosEntity{

    #[Id]
    #[GeneratedValue]
    #[Column(name: 'idPedidos', type: 'integer')]
    private int $idPedidos;

    #[ManyToOne(targetEntity: ProveedoresEntity::class, inversedBy: 'pedidos')]
    #[JoinColumn(name: 'idProveedor', referencedColumnName: 'idProveedor')]
    private ProveedoresEntity $proveedor;

    #[Column(name: 'fecha', type: Types::DATE_MUTABLE)]
    private DateTime $fecha;

    #[Column(name: 'detalles', type: 'string', length: 100, nullable: true)]
    private ?string $detalles=null;

    #[Column(name: 'estado', type: Types::BOOLEAN, options:['default'=>true])]
    private bool $estado=true;

    /**
     * Get the value of idPedidos
     */
    public function getIdPedidos(): int
    {
        return $this->idPedidos;
    }

    /**
     * Get the value of proveedor
     */
    public function getProveedor(): ProveedoresEntity
    {
        return $this->proveedor;
    }

    /**
     * Set the value of proveedor
     */
    public function setProveedor(ProveedoresEntity $proveedor): void
    {
        $this->proveedor = $proveedor;
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
     * Get the value of detalles
     */
    public function getDetalles(): ?string
    {
        return $this->detalles;
    }

    /**
     * Set the value of detalles
     */
    public function setDetalles(?string $detalles): void
    {
        $this->detalles = $detalles;
    }

    /**
     * Get the value of estado
     */
    public function getEstado(): bool
    {
        return $this->estado;
    }

    /**
     * Set the value of estado
     */
    public function setEstado(bool $estado): void
    {
        $this->estado = $estado;
    }
}