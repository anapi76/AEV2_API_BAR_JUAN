<?php

namespace app\Repository;

use app\Entity\ProductosEntity;
use app\Entity\StockEntity;
use DateTime;
use Doctrine\ORM\EntityRepository;

class StockRepository extends EntityRepository
{
    public function stock(): array
    {
        $productos = $this->findProductos();
        foreach ($productos as $producto) {
            $id = $producto->getIdProducto();
            $data = $this->findBy(['producto' => $id], ['fecha' => 'DESC']);
            $stock[] = $data[0];
        }
        return $stock;
    }

   /*  public function stockFecha(DateTime $fecha): ?array
    {
        $productos = $this->findProductos();
        //dump($fecha);
        foreach ($productos as $producto) {
            $id = $producto->getIdProducto();
            $data = $this->findBy(['producto' => $id, 'fecha' => $fecha], ['fecha' => 'DESC']);
            if (!empty($data)) {
                $stock[] = $data[0];
            } else {
                $stock = null;
            }
        }
        //dump($stock);
        return $stock;
    } */

    public function stockFechaArray(DateTime $fecha):?array
    {
        $entityManager = $this->getEntityManager();
        $fechaFin = $fecha->setTime(23, 59, 59);
        $stockRepository = $entityManager->getRepository(StockEntity::class);
        $stocks = $stockRepository->findAll();
        foreach ($stocks as $stock) {
            if (($stock->getFecha()->format('d-m-Y') >= $fecha->format('d-m-Y')) && ($stock->getFecha()->format('d-m-Y') <= $fechaFin->format('d-m-Y'))) {
                $stockDates[] = $stock;
            }
        }
        //dump($stockDates);
        return $stockDates;
    }

    public function findProductos(): array
    {
        $entityManager = $this->getEntityManager();
        $productosRepository = $entityManager->getRepository(ProductosEntity::class);
        $productos = $productosRepository->findAll();
        return $productos;
    }
}
