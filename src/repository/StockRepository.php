<?php

namespace app\Repository;

use app\Entity\ProductosEntity;
use app\Entity\StockEntity;
use DateTime;
use Doctrine\ORM\EntityRepository;

class StockRepository extends EntityRepository
{
    //Método que devuelve un array con el stock de todos los productos cuya cantidad sea mayor que cero, con la fecha más reciente
    public function stock(): ?array
    {
        $productos = $this->findProductos();
        if (!is_null($productos)) {
            foreach ($productos as $producto) {
                $data = $this->findBy(['producto' => $producto], ['fecha' => 'DESC']);
                $stock[] = $data[0];
            }
        } else {
            $stock = null;
        }
        return $stock;
    }

    //Método que devuelve un array con el stock de todos los productos con la fecha que le pasamos
    public function stockFechaArray(DateTime $fecha)
    {
        $fechaFin = $fecha->setTime(23, 59, 59);
        $productos = $this->findProductos();
        $data = [];

        if (!is_null($productos)) {
            foreach ($productos as $producto) {
                $arrayStock = $this->findBy(['producto' => $producto]);
                if (!empty($arrayStock)) {
                    $ultimoStock = null;
                    foreach ($arrayStock as $stock) {
                        $stockFecha = $stock->getFecha();
                        if ($stockFecha <= $fechaFin) {
                            if (is_null($ultimoStock) || $stockFecha > $ultimoStock->getFecha()) {
                                $ultimoStock = $stock;
                            }
                        }
                    }
                    if (!is_null($ultimoStock)) {
                        $data[] = $ultimoStock;
                    }
                }
            }
        }
        return $data;
    }

    /*  public function stockFechaArray(DateTime $fecha)
    {
        $fechaFin = $fecha->setTime(23, 59, 59);
        $productos = $this->findProductos();
        $data = [];

        if (!is_null($productos)) {
            foreach ($productos as $producto) {
                $arrayStock = $this->findBy(['producto' => $producto]);
                if (!empty($arrayStock)) {
                    $currentFecha = $fecha;
                    $ultimoStock = null;
                    foreach ($arrayStock as $stock) {
                        $stockFecha = $stock->getFecha();
                        if ($stockFecha >= $fecha && $stockFecha <= $fechaFin) {
                            if ($stockFecha > $currentFecha) {
                                $ultimoStock = $stock;
                                $currentFecha =  $stockFecha;
                            }
                        } elseif ($stockFecha < $fecha && (is_null($ultimoStock) || $stockFecha > $ultimoStock->getFecha())) {
                            $ultimoStock = $stock;
                            $currentFecha = $stockFecha;
                        }
                    }
                    if (!is_null($ultimoStock)) {
                        $data[] = $ultimoStock;
                    }
                }
            }
        }
        return $data;
    } */

    //Método que devuelve un array con todos los productos
    public function findProductos(): ?array
    {
        $entityManager = $this->getEntityManager();
        $productosRepository = $entityManager->getRepository(ProductosEntity::class);
        $productos = $productosRepository->findAll();
        if (empty($productos)) {
            $productos = null;
        }
        return $productos;
    }

    //Método que devuelve el stock con fecha más reciente del producto que le pasamos
    public function stockProducto(ProductosEntity $producto): StockEntity
    {
        $data = $this->findBy(['producto' => $producto], ['fecha' => 'DESC']);
        if (!is_null($producto)) {
            $stock = $data[0];
        } else {
            $stock = null;
        }
        return $stock;
    }

    //Método para persistir y hacer flush del nuevo stock
    public function crearStock(?StockEntity $newStock): bool
    {
        if (empty($newStock) || is_null($newStock)) {
            return false;
        } else {
            $entityManager = $this->getEntityManager();
            $entityManager->persist($newStock);
            $entityManager->flush();
            $entidad = $this->find($newStock);
            if (empty($entidad))
                return false;
            else {
                return true;
            }
        }
    }
}
