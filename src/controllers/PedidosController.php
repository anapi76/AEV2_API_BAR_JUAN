<?php

declare(strict_types=1);

//-- Declaramos el espacio de nombres de cada clase
namespace app\Controllers;

use app\Core\AbstractController;
use app\Core\EntityManager;
use app\Entity\PedidosEntity;
use app\Entity\ProveedoresEntity;
use DateTime;

class PedidosController extends AbstractController
{
    public function createPedido()
    {
        $entityManager = (new EntityManager)->getEntityManager();
        $proveedoresRepository = $entityManager->getRepository(ProveedoresEntity::class);

        if (count($_POST) > 0) {
            $id = intval($_POST['name']);
            $pedido = new PedidosEntity();
            $proveedor = $proveedoresRepository->find($id);
            $pedido->setProveedor($proveedor);
            $fecha = new DateTime();
            //dump($fecha);
            $pedido->setFecha($fecha);
            if (isset($_POST['detalles'])) {
                $pedido->setDetalles($_POST['detalles']);
            }
            $entityManager->persist($pedido);
            $entityManager->flush();
            $lineasPedido = new LineasPedidoController();
            $_POST = [];
            $lineasPedido->insertLineas($pedido);
        } else {
            $proveedores = $proveedoresRepository->findAll();
            $this->render(
                "pedidos.html.twig",
                //-- Le pasamos al renderizado los parámetros, que son todos los datos que hemos obtenido del modelo.
                [
                    'title' => 'Pedidos',
                    'title1' => 'Crear nuevo pedido',
                    'proveedores' => $proveedores
                ]
            );
        }
    }
}
