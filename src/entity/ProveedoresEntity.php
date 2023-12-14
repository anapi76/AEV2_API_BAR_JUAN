<?php

declare(strict_types=1);

namespace app\Entity;

use app\Repository\ProveedoresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: ProveedoresRepository::class)]
#[Table(name: 'proveedores')]
class ProveedoresEntity
{
    #[Id]
    #[GeneratedValue]
    #[Column(name: 'idProveedor', type: "integer")]
    private int $idProveedor;

    #[Column(name: 'nombre', type: 'string', length: 255, unique: true)]
    private string $nombre;

    #[Column(name: 'cif', type: 'string', length: 9, unique: true)]
    private string $cif;

    #[Column(name: 'direccion', type: 'string', length: 65535)]
    private string $direccion;

    #[Column(name: 'telefono', type: 'integer', nullable: true)]
    private ?int $telefono = null;

    #[Column(name: 'email', type: 'string', length: 100, nullable: true)]
    private ?string $email = null;

    #[Column(name: 'contacto', type: 'string', length: 100, nullable: true)]
    private ?string $contacto = null;

    #[OneToMany(targetEntity: PedidosEntity::class, mappedBy: 'proveedor')]
    private ?Collection $pedidos;

    public function __construct()
    {
        $this->pedidos = new ArrayCollection();
    }

    /**
     * Get the value of idProveedor
     */
    public function getIdProveedor(): int
    {
        return $this->idProveedor;
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
     * Get the value of cif
     */
    public function getCif(): string
    {
        return $this->cif;
    }

    /**
     * Set the value of cif
     */
    public function setCif(string $cif): void
    {
        $this->cif = $cif;
    }

    /**
     * Get the value of direccion
     */
    public function getDireccion(): string
    {
        return $this->direccion;
    }

    /**
     * Set the value of direccion
     */
    public function setDireccion(string $direccion): void
    {
        $this->direccion = $direccion;
    }

    /**
     * Get the value of telefono
     */
    public function getTelefono(): ?int
    {
        return $this->telefono;
    }

    /**
     * Set the value of telefono
     */
    public function setTelefono(?int $telefono): void
    {
        $this->telefono = $telefono;
    }

    /**
     * Get the value of email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * Get the value of contacto
     */
    public function getContacto(): ?string
    {
        return $this->contacto;
    }

    /**
     * Set the value of contacto
     */
    public function setContacto(?string $contacto): void
    {
        $this->contacto = $contacto;
    }

    /**
     * Get the value of pedidos
     */
    public function getPedidos(): ?Collection
    {
        return $this->pedidos;
    }

    /**
     * Set the value of pedidos
     */
    public function setPedidos(?Collection $pedidos): void
    {
        $this->pedidos = $pedidos;
    }
}
