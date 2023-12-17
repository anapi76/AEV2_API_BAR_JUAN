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
        $entityManager = $this->getEntityManager();
        $productosRepository = $entityManager->getRepository(ProductosEntity::class);
        $productos = $productosRepository->findAll();
        $repositoryStock = $entityManager->getRepository(StockEntity::class);
        foreach ($productos as $producto) {
            $id = $producto->getIdProducto();
            $data = $repositoryStock->findBy(['producto' => $id], ['fecha' => 'DESC']);
            $stock[] = $data[0];
        }

        return $stock;
    }

    public function stockFecha(string $fecha)
    {
        $entityManager = $this->getEntityManager();
        $productosRepository = $entityManager->getRepository(ProductosEntity::class);
        $productos = $productosRepository->findAll();
        $repositoryStock = $entityManager->getRepository(StockEntity::class);
        //dump($fecha);
        foreach ($productos as $producto) {
            $id = $producto->getIdProducto();
            $date = new DateTime($fecha);
            $data = $repositoryStock->findBy(['producto' => $id, 'fecha' => $date], ['fecha' => 'DESC']);
            if(!empty($data)){
                $stock[] = $data[0];
            }
        }
        //dump($stock);
        return $stock;
    }
}
