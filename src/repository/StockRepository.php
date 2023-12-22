<?php

namespace app\Repository;

use app\Entity\ProductosEntity;
use app\Entity\StockEntity;
use DateTime;
use Doctrine\ORM\EntityRepository;

class StockRepository extends EntityRepository
{
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

    public function stockFechaArray(DateTime $fecha): ?array
    {
        $entityManager = $this->getEntityManager();
        $fechaFin = $fecha->setTime(23, 59, 59);
        $stockRepository = $entityManager->getRepository(StockEntity::class);
        $stockArray = $stockRepository->findAll();
        if (!empty($stockArray)) {
            foreach ($stockArray as $stock) {
                if (($stock->getFecha()->format('d-m-Y') >= $fecha->format('d-m-Y')) && ($stock->getFecha()->format('d-m-Y') <= $fechaFin->format('d-m-Y'))) {
                    $data[] = $stock;
                }
            }
        } else {
            $data = null;
        }
        //dump($data);
        return $data;
    }

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
}
