<?php

namespace app\Repository;

use app\Entity\ProductosEntity;
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

    public function stockFecha(string $fecha):?array
    {
        $productos = $this->findProductos();
        //dump($fecha);
        foreach ($productos as $producto) {
            $id = $producto->getIdProducto();
            $date = new DateTime($fecha);
            $data = $this->findBy(['producto' => $id, 'fecha' => $date], ['fecha' => 'DESC']);
            if (!empty($data)) {
                $stock[] = $data[0];
            }
            else{
                $stock=null;
            }
        }
        //dump($stock);
        return $stock;
    }

    public function findProductos(): array
    {
        $entityManager = $this->getEntityManager();
        $productosRepository = $entityManager->getRepository(ProductosEntity::class);
        $productos = $productosRepository->findAll();
        return $productos;
    }
}
