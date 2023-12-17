<?php

declare(strict_types=1);

//-- Declaramos el espacio de nombres de cada clase
namespace app\Controllers;

use app\Core\AbstractController;
use app\Core\EntityManager;
use app\Entity\ProductosEntity;

class LineasPedidoController extends AbstractController
{
    public function insertLineas($pedido)
    {
        $entityManager = (new EntityManager)->getEntityManager();
        $productosRepository = $entityManager->getRepository(ProductosEntity::class);

        if (count($_POST) > 0) {
            /*  $poducto = new PedidosEntity();
            $proveedor = $proveedoresRepository->find($id);
            $pedido->setProveedor($proveedor);
            $fecha = new DateTime();
            dump($fecha);
            $pedido->setFecha($fecha);
            if(isset($_POST['detalles'])){
                $pedido->setDetalles($_POST['detalles']);
            }
            $entityManager->persist($pedido);
            $entityManager->flush();
            $lineasPedido=new LineasPedidoController();
            $lineasPedido->insertLineas($pedido); */
        } else {
            $productos = $productosRepository->findAll();
            $this->render(
                "lineasPedido.html.twig",
                //-- Le pasamos al renderizado los parámetros, que son todos los datos que hemos obtenido del modelo.
                [
                    'title' => 'Lineas de Pedido',
                    'title1' => 'Insertar las líneas del pedido',
                    'pedido' => $pedido,
                    'productos' => $productos
                ]
            );
        }
    }
}
