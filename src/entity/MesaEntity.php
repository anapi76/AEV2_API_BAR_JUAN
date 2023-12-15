<?php
declare(strict_types=1);
namespace app\Entity;

use app\Repository\MesaRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
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
}