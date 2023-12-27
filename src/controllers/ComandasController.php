<?php

declare(strict_types=1);

//-- Declaramos el espacio de nombres de cada clase
namespace app\Controllers;

use app\Core\AbstractController;
use app\Core\EntityManager;
use app\Entity\ComandasEntity;
use app\Entity\LineasComandasEntity;
use app\Entity\MesaEntity;
use app\Entity\ProductosEntity;
use app\Entity\StockEntity;
use DateTime;

class ComandasController extends AbstractController
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

    //Método para seleccionar el POST  o el PUT
    public function crearComanda(string $idComanda = null)
    {
        //Compruebo el método y lo paso al switch
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'POST':
                //Si el id de la comanda es nulo llama al método de insertar la comanda, sino lanzará un mensaje de error
                if (is_null($idComanda)) {
                    $this->insertarComanda($method);
                } else {
                    $msg = 'El metodo ' . $method . ' no es valido para esta peticion. ';
                    echo $this->main->jsonResponse($method, $msg, 400);
                }
                break;
            case 'PUT':
                //Si el id de la comanda no es nulo llama al método de actualizar la comanda, sino lanzará un mensaje de error
                if (!is_null($idComanda)) {
                    $this->actualizarComanda($method, $idComanda);
                } else {
                    $msg = 'El metodo ' . $method . ' no es valido para esta peticion. ';
                    echo $this->main->jsonResponse($method, $msg, 400);
                }
                break;
        }
    }

    //Método para insertar una comanda nueva
    public function insertarComanda($method): void
    {
        //Obtenemos los datos de la solicitud post
        $jsonData = file_get_contents('php://input');
        //Decodificamos el json y lo metemos en un array
        $data = json_decode($jsonData, true);
        //Si el array no es null creamos la comanda, sino lanzaremos un error
        if (!is_null($data)) {
            //Comprobamos que los datos que no pueden ser null para crear la comanda, existen y no están vacíos, sino lanzará un mensaje de error
            if (isset($data["mesa"]) && !empty($data["mesa"]) && isset($data["comensales"]) && !empty($data["comensales"])) {
                //Creo una instancia de ComandasEntity
                $comanda = new ComandasEntity();
                //Introduzco la fecha actual para crear la nueva comanda
                $comanda->setFecha(new DateTime());
                //Busco la mesa con el nombre que hemos recibido y la introduzco
                $mesa = $this->findMesa($data['mesa']);
                $comanda->setMesa(($mesa));
                //Si hemos recibido detalles, los introduzco en el pedido
                if (isset($data["detalles"]) && !empty($data["detalles"])) {
                    $comanda->setDetalles($data["detalles"]);
                }
                //Compruebo que el número de comensales caben en la mesa, sino, lanza un mensaje de error
                if ($data['comensales'] > $mesa->getComensales()) {
                    $msg = 'Los comensales no caben en la mesa seleccionada. ';
                    echo $this->main->jsonResponse($method, $msg, 400);
                } else {
                    //Si los comensales caben en la mesa, introduzco el número y persisto la comanda
                    $comanda->setComensales(intval($data['comensales']));
                    $this->em->getEntityManager()->persist($comanda);
                    //Compruebo si hemos recibido líneas de comanda, si no hay la comanda no se creará y lanzará un mensaje de error
                    if (isset($data['lineas']) && !empty($data['lineas'])) {
                        $cont = 0;
                        $lineas = $data['lineas'];
                        //Recorro las lineas de la comanda, para comprobar si la linea está declarada y no está vacía
                        foreach ($lineas as $linea) {
                            if (isset($linea) && !empty($linea)) {
                                //Creo una instancia de una lineaComanda
                                $lineasComanda = new LineasComandasEntity();
                                //Si el producto y la cantidad están declarados y no están vacíos, crear la linea de comanda
                                if (isset($linea['producto']) && !empty($linea['producto']) && isset($linea['cantidad']) && !empty($linea['cantidad'])) {
                                    //Busco el objeto producto y lo introduzco en la linea
                                    $producto = $this->findProducto($linea['producto']);
                                    $lineasComanda->setProducto($producto);
                                    //Introduzco la cantidad
                                    $lineasComanda->setCantidad(floatval($linea['cantidad']));
                                    //Introduzco la comanda que he persistido
                                    $lineasComanda->setComanda($comanda);
                                    //Añado la lineaComanda al arrayCollection de la comanda
                                    $comanda->getLineasComanda()->add($lineasComanda);
                                    //persisto lineaComanda
                                    $this->em->getEntityManager()->persist($lineasComanda);
                                    $cont++;
                                }
                            }
                        }
                        //si el contador que he inicializado es mayor que 0, hago un flush, sino, el pedido no se creará en la BD porque no tiene líneas de comanda
                        if ($cont > 0) {
                            $this->em->getEntityManager()->flush();
                            $comandaRepository = $this->em->getEntityManager()->getRepository(ComandasEntity::class);
                            //Compruebo que la comanda se ha insertado correctamente y lo muestro por pantalla, si no se ha podido insertar saltará un mensaje de error
                            if ($comandaRepository->testInsert($comanda)) {
                                $msg = 'Se ha insertado la comanda con Id: ' . $comanda->getIdComanda();
                                echo json_encode($msg, http_response_code(201));
                            } else {
                                $msg = 'No se ha podido insertar la comanda. ';
                                echo $this->main->jsonResponse($method, $msg, 500);
                            }
                        } else {
                            $msg = 'No se ha podido crear la comanda, porque faltan lineas. ';
                            echo $this->main->jsonResponse($method, $msg, 400);
                        }
                    } else {
                        $msg = 'No se ha podido crear la comanda, porque faltan lineas. ';
                        echo $this->main->jsonResponse($method, $msg, 400);
                    }
                }
            } else {
                $msg = 'No se ha creado la comanda, porque falta algun parametro. ';
                echo $this->main->jsonResponse($method, $msg, 400);
            }
        } else {
            $msg = 'Error al decodificar el archivo json. ';
            echo $this->main->jsonResponse($method, $msg, 500);
        }
    }

    //Método para actualizar una comanda
    public function actualizarComanda($method, $idComanda): void
    {
        //Obtenemos los datos de la solicitud post
        $jsonData = file_get_contents('php://input');
        //Decodificamos el json y lo metemos en un array
        $data = json_decode($jsonData, true);
        if (!is_null($data)) {
            //Instancio el repositorio de comandas para buscar la comanda que vamos a actualizar
            $comandaRepository = $this->em->getEntityManager()->getRepository(ComandasEntity::class);
            $comanda = $comandaRepository->find(intval($idComanda));
            //Si la comanda no es null empezará la actualización sino, lanzará un mensaje de error
            if (!is_null($comanda)) {
                $cont = 0;
                if (isset($data['fecha']) && !empty($data['fecha'])) {
                    $fecha = new DateTime($data['fecha']);
                    $comanda->setFecha($fecha);
                    $cont++;
                }
                if (isset($data['mesa']) && !empty($data['mesa'])) {
                    $mesa = $this->findMesa($data['mesa']);
                } else {
                    $mesa = $comanda->getMesa();
                }
                if (isset($data['comensales']) && !empty($data['comensales'])) {
                    if ($data['comensales'] > $mesa->getComensales()) {
                        $msg = 'Los comensales no caben en la mesa seleccionada. ';
                        echo $this->main->jsonResponse($method, $msg, 400);
                    } else {
                        //Si los comensales caben en la mesa, introduzco la mesa y el número
                        $comanda->setMesa($mesa);
                        $comanda->setComensales(intval($data['comensales']));
                        $cont++;
                        if (isset($data['detalles']) && !empty($data['detalles'])) {
                            $comanda->setDetalles($data['detalles']);
                            $cont++;
                        }
                        $this->em->getEntityManager()->persist($comanda);
                        if (isset($data["lineas"]) && !empty($data["lineas"])) {
                            $lineas = $data["lineas"];
                            //Recorro las lineas de comanda, para comprobar si la linea no está vacía
                            foreach ($lineas as $index => $linea) {
                                if (isset($linea) && !empty($linea)) {
                                    //Asigno el indice 0 para crear una nueva línea
                                    if ($index == 0) {
                                        //Creo una nueva instancia de una linea
                                        $lineaComanda = new LineasComandasEntity();
                                        //Añado la lineaComanda al arrayCollection de la comanda
                                        $comanda->getLineasComanda()->add($lineaComanda);
                                        //Introduzco la comanda que he persistido
                                        $lineaComanda->setComanda($comanda);
                                    } else {
                                        $lineaComandaRepository = $this->em->getEntityManager()->getRepository(LineasComandasEntity::class);
                                        //Busco la lineaComanda que voy a actualizar
                                        $lineaComanda = $lineaComandaRepository->find($index);
                                    }
                                    //Si el producto está declarado y no está vacío, actualizo
                                    if (isset($linea['producto']) && !empty($linea['producto'])) {
                                        //Busco el objeto producto y lo introduzco en la linea
                                        $producto = $this->findProducto($linea['producto']);
                                        $lineaComanda->setProducto($producto);
                                        $cont++;
                                    }
                                    //Si la cantidad está declarada y no está vacía, actualizo
                                    if (isset($linea['cantidad']) && !empty($linea['cantidad'])) {
                                        $lineaComanda->setCantidad(floatval($linea['cantidad']));
                                        $cont++;
                                    }
                                    //persisto lineaComanda
                                    $this->em->getEntityManager()->persist($lineaComanda);
                                }
                            }
                        }
                        //Si el contador que he inicializado es mayor que 0, hago un flush
                        if ($cont > 0) {
                            $this->em->getEntityManager()->flush();
                            //Compruebo que la comanda se ha insertado correctamente y lo muestro por pantalla, si no se ha podido insertar saltará un mensaje de error
                            if ($comandaRepository->testInsert($comanda)) {
                                $msg = 'Se ha actualizado la comanda con Id: ' . $comanda->getIdComanda();
                                echo json_encode($msg, http_response_code(201));
                            } else {
                                $msg = 'No se ha podido actualizar la comanda. ';
                                echo $this->main->jsonResponse($method, $msg, 500);
                            }
                        } else {
                            $msg = 'No se ha actualizado ningun campo de la comanda. ';
                            echo $this->main->jsonResponse($method, $msg, 400);
                        }
                    }
                }
            } else {
                $msg = 'La comanda no existe. ';
                echo $this->main->jsonResponse($method, $msg, 400);
            }
        } else {
            $msg = 'Error al decodificar el archivo json. ';
            echo $this->main->jsonResponse($method, $msg, 500);
        }
    }

    public function entregadaLineaComanda(string $idComanda)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'PATCH') {
            //Obtenemos los datos de la solicitud post
            $jsonData = file_get_contents('php://input');
            //Decodificamos el json y lo metemos en un array
            $data = json_decode($jsonData, true);
            if (!is_null($data)) {
                $comandaRepository = $this->em->getEntityManager()->getRepository(ComandasEntity::class);
                $stockRepository = $this->em->getEntityManager()->getRepository(StockEntity::class);
                $comanda = $comandaRepository->find(intval($idComanda));
                if (!is_null($comanda)) {
                    if (isset($data) && !empty($data)) {
                        //Recorro las lineas de comanda, para comprobar si la linea no está vacía
                        $test = true;
                        foreach ($data as $index => $linea) {
                            if (isset($linea) && !empty($linea)) {
                                $lineaComandaRepository = $this->em->getEntityManager()->getRepository(LineasComandasEntity::class);
                                //Busco la lineaComanda que voy a actualizar
                                $lineaComanda = $lineaComandaRepository->find($index);
                                //Cambio el estado de linea a entregado persisto y flusheo
                                $lineaComanda->setEntregado(true);
                                $this->em->getEntityManager()->persist($lineaComanda);
                                $this->em->getEntityManager()->flush();
                                //Busco el producto para actualizar el stock
                                $producto = $this->findProducto($linea['producto']);
                                $cantidad = intval($linea['cantidad']);
                                //llamo al repositorio de stock para buscar el último stock del producto
                                $stockRepository = $this->em->getEntityManager()->getRepository(StockEntity::class);
                                $stock = $stockRepository->stockProducto($producto);
                                //Creo un nuevo stock con la cantidad actualizada
                                $nuevaCantidad = $stock->getCantidad() - $cantidad;
                                $newStock = $stockRepository->crearStock($producto, $nuevaCantidad);
                                //Compruebo que se han actualizado el stock de todos los productos
                                if (!($stockRepository->testInsert($newStock))) {
                                    $test = false;
                                }
                            }
                        }
        
                        if ($test == true) {
                            $msg = 'Se han creado nuevos stocks';
                            echo json_encode($msg, http_response_code(201));
                        } else {
                            $msg = 'No se ha podido crear el nuevo stock. ';
                            echo $this->main->jsonResponse($method, $msg, 500);
                        }
                    }
                    //Compruebo si todas las lineasComanda de la comanda están entregada y cambio el estado de la comanda
                    $lineas = $comanda->getLineasComanda()[0];
                    $entregado = true;
                    foreach ($lineas as $linea) {
                        if ($linea->isEntregado() == false) {
                            $entregado = false;
                        }
                    }
                    if ($entregado) {
                        $comanda->setEstado(false);
                        $this->em->getEntityManager()->persist($lineaComanda);
                        $this->em->getEntityManager()->flush();
                    }
                } else {
                    $msg = 'La comanda no existe. ';
                    echo $this->main->jsonResponse($method, $msg, 400);
                }
            } else {
                $msg = 'Error al decodificar el archivo json. ';
                echo $this->main->jsonResponse($method, $msg, 500);
            }
        } else {
            $msg = 'El metodo ' . $method . ' no es valido para esta peticion. ';
            echo $this->main->jsonResponse($method, $msg, 400);
        }
    }

    //Metodo que busca el detalle de una comanda
    public function detalleComanda(?string $idComanda = null): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        //Verificamos que la solicitud viene por POST, sino lanzaremos un error
        if ($method === 'GET') {
            if (!is_null($idComanda)) {
                $comandaRepository = $this->em->getEntityManager()->getRepository(ComandasEntity::class);
                $comanda = $comandaRepository->find(intval($idComanda));
                if (!is_null($comanda)) {
                    $comandaJSON = $comandaRepository->comandaJSON($comanda);
                    echo json_encode($comandaJSON, JSON_PRETTY_PRINT);
                } else {
                    $msg = 'La comanda no existe. ';
                    echo $this->main->jsonResponse($method, $msg, 400);
                }
            } else {
                $msg = 'El id de la comanda es nulo. ';
                echo $this->main->jsonResponse($method, $msg, 400);
            }
        } else {
            $msg = 'El metodo ' . $method . ' no es valido para esta peticion. ';
            echo $this->main->jsonResponse($method, $msg, 400);
        }
    }

    //Método que busca un objeto mesa
    public function findMesa(string $name): mixed
    {
        $mesaRepository = $this->em->getEntityManager()->getRepository(MesaEntity::class);
        $mesa = $mesaRepository->findOneBy(['nombre' => $name]);
        if (!is_null($mesa)) {
            return $mesa;
        } else {
            $msg = 'La mesa no existe. ';
            echo $this->main->jsonResponse(null, $msg, 400);
        }
    }

    //Método que busca un objeto producto
    public function findProducto(string $name): mixed
    {
        $productosRepository = $this->em->getEntityManager()->getRepository(ProductosEntity::class);
        $producto = $productosRepository->findOneBy(['nombre' => $name]);
        if (!is_null($producto)) {
            return $producto;
        } else {
            $msg = 'El producto no existe. ';
            echo $this->main->jsonResponse(null, $msg, 400);
        }
    }
}



/* json para crear/actualizar comanda postman
{
   "mesa":"mesa1",
   "comensales":"3",
   "lineas":{
    "0":{
    "producto":"producto1",
    "cantidad":7
     },
    "13":{
    "producto":"producto10",
    "cantidad":10
    }
   }
}*/
