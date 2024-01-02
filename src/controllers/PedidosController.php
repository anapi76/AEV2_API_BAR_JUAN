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
    //creo una instancia del EntityManager y el MainController
    private EntityManager $em;
    private MainController $main;

    //Inicializo el EntityManager y el MainController en el constructor
    public function __construct()
    {
        $this->em = new EntityManager();
        $this->main = new MainController();
        parent::__construct();
    }

    //Método para crear un pedido
    public function crearPedido(): void
    {
        //Creo un repositorio de proveedores
        $proveedoresRepository = $this->em->getEntityManager()->getRepository(ProveedoresEntity::class);
        //Creo un repositorio de productos
        $productosRepository = $this->em->getEntityManager()->getRepository(ProductosEntity::class);
        //si recibimos parámetros por post, empezará a crear el pedido, sino, mostrará el formulario para hacer el pedido
        if (count($_POST) > 0) {
            // Compruebo si tenemos el id del proveedor para crear el pedido, si no lo tenemos saltará un mensaje de error
            if (isset($_POST['idProveedor']) && !empty($_POST['idProveedor'])) {
                //Creo una instancia de PedidosEntity
                $pedido = new PedidosEntity();
                //Convierto el id del proveedor que viene como string a integer
                $id = intval($_POST['idProveedor']);
                //Busco el proveedor
                $proveedor = $proveedoresRepository->find($id);
                //Introduzco el proveedor
                $pedido->setProveedor($proveedor);
                //Introduzco la fecha actual
                $pedido->setFecha(new DateTime());
                //Si hemos recibido detalles, los introduzco en el pedido
                if (isset($_POST['detalles'])) {
                    $pedido->setDetalles($_POST['detalles']);
                }
                //Persisto el pedido pero no lo fluseo hasta comprobar si tenemos líneas de pedido
                $this->em->getEntityManager()->persist($pedido);

                //compruebo si tenemos líneas de pedido, si no hay, el pedido no se creará y saltará un error
                if (isset($_POST['cantidades'])) {
                    //Incializo un contador
                    $cont = 0;
                    $cantidades = $_POST['cantidades'];
                    //Recorro las lineas de pedido, para comprobar si la linea del producto no está vacía
                    foreach ($cantidades as $index => $cantidad) {
                        if (!empty($cantidad)) {
                            //Creo una instancia de una lineaPedido
                            $lineasPedido = new LineasPedidosEntity();
                            //Busco el producto por su id,que me viene por el value del formulario
                            $producto = $productosRepository->find($index);
                            //Inserto el producto en la LineaPedido
                            $lineasPedido->setProducto($producto);
                            //Inserto la cantidad
                            $lineasPedido->setCantidad(floatval($cantidad));
                            //inserto el pedido que hemos peristido
                            $lineasPedido->setPedido($pedido);
                            //persisto lineaPedido
                            $this->em->getEntityManager()->persist($lineasPedido);
                            //Añado la lineaPedido al arrayCollection del pedido
                            $pedido->getLineasPedido()->add($lineasPedido);
                            $cont++;
                        }
                    }
                    //si el contador que he inicializado es mayor que 0, hago un flush, sino, el pedido no se creará en la BD porque no tiene líneas de pedido
                    if ($cont > 0) {
                        $this->em->getEntityManager()->flush();
                        $pedidoRepository = $this->em->getEntityManager()->getRepository(PedidosEntity::class);
                        //Compruebo que el pedido se ha insertado correctamente y lo muestro por pantalla, si no se ha podido insertar saltará un mensaje de error
                        if ($pedidoRepository->testInsert($pedido)) {
                            $pedidoJSON = $pedidoRepository->pedidoJSON($pedido);
                            echo json_encode($pedidoJSON, JSON_PRETTY_PRINT);
                        } else {
                            $msg = 'No se ha podido insertar el pedido. ';
                            echo $this->main->jsonResponse(null, $msg, 500);
                        }
                    } else {
                        $msg = 'No se ha creado el pedido, porque no se ha introducido ninguna linea de pedido. ';
                        echo $this->main->jsonResponse(null, $msg, 400);
                    }
                } else {
                    $msg = 'No se ha creado el pedido, porque no se ha introducido ninguna linea de pedido. ';
                    echo $this->main->jsonResponse(null, $msg, 400);
                }
            } else {
                $msg = 'No se ha introducido el proveedor. ';
                echo $this->main->jsonResponse(null, $msg, 400);
            }
        } else {
            //Saco todos los proveedores y todos los productos para pasárselos al formulario
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

    //Método que lista todos los pedidos
    public function listarPedidos(): void
    {
        $pedidosRepository = $this->em->getEntityManager()->getRepository(PedidosEntity::class);
        $pedidos = $pedidosRepository->listarPedidosJSON();
        echo json_encode($pedidos, JSON_PRETTY_PRINT);
    }
}
