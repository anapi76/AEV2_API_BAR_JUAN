<?php

declare(strict_types=1);

//-- Declaramos el espacio de nombres de cada clase
namespace app\Controllers;

use app\Core\AbstractController;
use app\Core\EntityManager;
use app\Entity\LineasPedidosEntity;
use app\Entity\PedidosEntity;
use app\Entity\ProductosEntity;
use app\Entity\ProveedoresEntity;
use DateTime;

class PedidosController extends AbstractController
{
    public function crearPedido(): void
    {
        $entityManager = (new EntityManager)->getEntityManager();
        $proveedoresRepository = $entityManager->getRepository(ProveedoresEntity::class);
        $productosRepository = $entityManager->getRepository(ProductosEntity::class);
        if (count($_POST) > 0) {
            // Introducimos los datos del nuevo pedido
            if (isset($_POST['idProveedor'])) {
                $pedido = new PedidosEntity();
                $id = intval($_POST['idProveedor']);
                $proveedor = $proveedoresRepository->find($id);
                $pedido->setProveedor($proveedor);
                $fecha = new DateTime();
                $pedido->setFecha($fecha);
                if (isset($_POST['detalles'])) {
                    $pedido->setDetalles($_POST['detalles']);
                }
            //Introducimos los datos de cada línea de pedido
                $cantidades = $_POST['cantidades'];
                $cont = 0;
                foreach ($cantidades as $index => $cantidad) {
                    if (!empty($cantidad)) {
                        $lineasPedido = new LineasPedidosEntity();
                        $producto = $productosRepository->find($index);
                        $lineasPedido->setProducto($producto);
                        $lineasPedido->setCantidad(floatval($cantidad));
                        $lineasPedido->setPedido($pedido);
                        $entityManager->persist($lineasPedido);
                        $pedido->getLineasPedido()->add($lineasPedido);
                        $cont++;
                    }
                }
                if ($cont > 0) {
                    $entityManager->persist($pedido);
                    $entityManager->flush();
                    $pedidoRepository = $entityManager->getRepository(PedidosEntity::class);
                    if ($pedidoRepository->insert($pedido)) {
                        $pedidoJSON = $pedidoRepository->pedidoJSON($pedido);
                        echo json_encode($pedidoJSON,JSON_PRETTY_PRINT);
                    } else {
                        $main = new MainController();
                        $msg = 'No se ha podido insertar el pedido. ';
                        echo $main->json400($msg);
                    }
                } else {
                    $main = new MainController();
                    $msg = 'No se ha creado el pedido, no se ha introducido ninguna linea de pedido. ';
                    echo $main->json400($msg);
                }
            } else {
                $main = new MainController();
                $msg = 'No se ha introducido el proveedor. ';
                echo $main->json400($msg);
            }
        } else {
            $proveedores = $proveedoresRepository->findAll();
            $productos = $productosRepository->findAll();

            $this->render(
                "pedidos.html.twig",
                //-- Le pasamos al renderizado los parámetros, que son todos los datos que hemos obtenido del modelo.
                [
                    'title' => 'Pedidos',
                    'title1' => 'Crear nuevo pedido',
                    'proveedores' => $proveedores,
                    'productos' => $productos
                ]
            );
        }
    }

    public function listarPedidos():void
    {
        $entityManager = (new EntityManager)->getEntityManager();
        $pedidosRepository = $entityManager->getRepository(PedidosEntity::class);
        $pedidos = $pedidosRepository->listarPedidosJSON();
        echo json_encode($pedidos,JSON_PRETTY_PRINT);
    }
}
