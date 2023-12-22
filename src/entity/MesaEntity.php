<?php
declare(strict_types=1);
namespace app\Entity;

use app\Repository\MesaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: MesaRepository::class)]
#[Table(name: 'mesa')]
class MesaEntity {
    #[Id]
    #[GeneratedValue]
    #[Column(name: 'idMesa', type: 'integer')]
    private int $idMesa;

    #[Column(name: 'nombre', type: 'string', length: 50, unique: true)]
    private string $nombre;

    #[Column(name: 'comensales', type: 'integer')]
    private int $comensales;

    //Una comanda tiene muchas lineas de comanda(bidireccional)
    #[OneToMany(targetEntity: ComandasEntity::class, mappedBy: 'mesa')]
    private ?Collection $comandas;

    public function __construct()
    {
        $this->comandas = new ArrayCollection();
    }

    /**
     * Get the value of idMesa
     */
    public function getIdMesa(): int
    {
        return $this->idMesa;
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
     * Get the value of comensales
     */
    public function getComensales(): int
    {
        return $this->comensales;
    }

    /**
     * Set the value of comensales
     */
    public function setComensales(int $comensales): void
    {
        $this->comensales = $comensales;
    }

    /**
     * Get the value of comandas
     */
    public function getComandas(): ?Collection
    {
        return $this->comandas;
    }

    /**
     * Set the value of comandas
     */
    public function setComandas(?Collection $comandas):void
    {
        $this->comandas = $comandas;
    }
}