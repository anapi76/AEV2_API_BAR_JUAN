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
                if ($data[0]->getCantidad() > 0) {
                    $stock[] = $data[0];
                }
            }
        } else {
            $stock = null;
        }
        return $stock;
    }

    //Método que devuelve un array con el stock de todos los productos cuya cantidad sea mayor que cero, con la fecha que le decimos, si la fecha que le decimos no existe devolverá null
    public function stockFechaArray(DateTime $fecha): ?array
    {
        $entityManager = $this->getEntityManager();
        $fechaFin = $fecha->setTime(23, 59, 59);
        $stockRepository = $entityManager->getRepository(StockEntity::class);
        $stockArray = $stockRepository->findAll();
        if (!empty($stockArray)) {
            $data = [];
            foreach ($stockArray as $stock) {
                if (($stock->getFecha()->format('d-m-Y') >= $fecha->format('d-m-Y')) && ($stock->getFecha()->format('d-m-Y') <= $fechaFin->format('d-m-Y'))) {
                    if ($stock->getCantidad() > 0) {
                        $data[] = $stock;
                    }
                }
            }
        } else {
            $data = null;
        }
        return $data;
    }

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
