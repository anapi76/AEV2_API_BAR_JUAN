<?php

declare(strict_types=1);

//-- Declaramos el espacio de nombres de cada clase
namespace app\Controllers;

use app\Core\AbstractController;
use app\Core\EntityManager;
use app\Entity\LineasPedidosEntity;
use app\Entity\PedidosEntity;
use app\Entity\ProductosEntity;

class LineasPedidoController extends AbstractController
{
    /* public function insertLineas(PedidosEntity $pedido)
    {
        $entityManager = (new EntityManager)->getEntityManager();
        $productosRepository = $entityManager->getRepository(ProductosEntity::class);
        if (count($_POST) > 0) {
            $lineasPedido = new LineasPedidosEntity();
            $id = intval($_POST['idProducto']);
            $producto = $productosRepository->find($id);
            $lineasPedido->setProducto($producto);
            $lineasPedido->setCantidad(floatval($_POST['cantidad']));
            $lineasPedido->setPedido($pedido);
            $lineasPedidoRepository = $entityManager->getRepository(LineasPedidosEntity::class);
            dump($lineasPedido);
            if ($lineasPedidoRepository->insert($lineasPedido)) {
                
            } else {
                $main = new MainController();
                $msg = 'No se ha podido insertar el detalle';
                $main->json400($msg);
            }  
        } else {
 
        }
    } */
}
