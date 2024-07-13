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
use DateTime;
use Exception;

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
    public function insertarComanda(string $idComanda = null): void
    {
        //Compruebo el método y lo paso al switch
        $method = $_SERVER['REQUEST_METHOD'];
        switch ($method) {
            case 'POST':
                //Si el id de la comanda es nulo llama al método de insertar la comanda, sino lanzará un mensaje de error
                if (is_null($idComanda)) {
                    $this->crearComanda($method);
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

    //Método para crear una comanda nueva
    public function crearComanda(string $method): void
    {
        try {
            //Obtenemos los datos de la solicitud post
            $jsonData = file_get_contents('php://input');
            //Decodificamos el json y lo metemos en un array
            $data = json_decode($jsonData, true);
            //Si el array no es null creamos la comanda, sino lanzaremos un error
            if (!is_null($data)) {
                //Comprobamos que los datos que no pueden ser null para crear la comanda, existen y no están vacíos, sino lanzará un mensaje de error
                if (isset($data["mesa"]) && !empty($data["mesa"]) && isset($data["comensales"]) && !empty($data["comensales"]) && isset($data["fecha"]) && !empty($data["fecha"])) {
                    //Creo una instancia de ComandasEntity
                    $comanda = new ComandasEntity();
                    //Introduzco la fecha actual para crear la nueva comanda
                    $fecha = DateTime::createFromFormat("d/m/Y H:i:s", $data["fecha"]);
                    $comanda->setFecha($fecha);
                    //Busco la mesa con el nombre que hemos recibido y la introduzco
                    $mesaRepository = $this->em->getEntityManager()->getRepository(MesaEntity::class);
                    $mesa = $mesaRepository->findMesa($data['mesa']);
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
                            //Inicializo un contador para comprobar si se hemos recibido alguna lineaComanda
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
                                        $productosRepository = $this->em->getEntityManager()->getRepository(ProductosEntity::class);
                                        $producto = $productosRepository->findProducto($linea['producto']);
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
                            //si se han recibio lineaComandas, hago un flush, sino, el pedido no se creará en la BD porque no tiene líneas de comanda
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
        } catch (Exception $e) {
            $msg = 'Error del servidor: ' . $e->getMessage();
            echo $this->main->jsonResponse($method, $msg, 500);
        }
    }

    //Método para actualizar una comanda
    public function actualizarComanda(string $method, string $idComanda): void
    {
        try {
            //Obtenemos los datos de la solicitud post
            $jsonData = file_get_contents('php://input');
            //Decodificamos el json y lo metemos en un array
            $data = json_decode($jsonData, true);
            if (!is_null($data)) {
                //Instancio el repositorio de comandas para buscar la comanda que vamos a actualizar
                $comandaRepository = $this->em->getEntityManager()->getRepository(ComandasEntity::class);
                $comanda = $comandaRepository->find(intval($idComanda));
                //Si la comanda no es null empezará la actualización, sino lanzará un mensaje de error
                if (!is_null($comanda)) {
                    if (isset($data['fecha']) && !empty($data['fecha'])) {
                        $fecha = DateTime::createFromFormat("d/m/Y H:i:s", $data["fecha"]);
                        $comanda->setFecha($fecha);
                    }
                    //Compruebo los campos que están declarados y no están vacíos para actualizar la comanda
                    //Si mesa no se ha actualizado, saco el objeto mesa de la comanda a actualizar, para comprobar si caben los comensales, en caso de que se hayan modificado, si se ha actualizado la modifico en la comanda
                    if (isset($data['mesa']) && !empty($data['mesa'])) {
                        $mesaRepository = $this->em->getEntityManager()->getRepository(MesaEntity::class);
                        $mesa = $mesaRepository->findMesa($data['mesa']);
                        $comanda->setMesa($mesa);
                    }
                    //Si los comensales no se han actualizado, los saco de la comanda
                    if (isset($data['comensales']) && !empty($data['comensales'])) {
                        $comensales = $data['comensales'];
                        $comanda->setComensales(intval($data['comensales']));
                    }
                    //Si los comensales caben en la mesa continuará con la actualización de la comanda, sino lanzará un mensaje de error
                    if ($comensales <= $mesa->getComensales()) {
                        if (isset($data['detalles']) && !empty($data['detalles'])) {
                            $comanda->setDetalles($data['detalles']);
                        }
                        //persisto la comanda
                        $this->em->getEntityManager()->persist($comanda);
                        //compruebo si hemos recibido líneas de comanda para actualizar o añadir
                        if (isset($data["lineas"]) && !empty($data["lineas"])) {
                            $lineas = $data["lineas"];
                            //Recorro las lineas de comanda, para comprobar si la linea no está vacía
                            foreach ($lineas as $index => $linea) {
                                if (isset($linea) && !empty($linea)) {
                                    //Creo un repositorio de lineaComanda
                                    $lineaComandaRepository = $this->em->getEntityManager()->getRepository(LineasComandasEntity::class);
                                    //Busco la lineaComanda que voy a actualizar
                                    $lineaComanda = $lineaComandaRepository->find($index);
                                    if (is_null($lineaComanda)) {
                                        //Se creará una nueva linea comanda
                                        $lineaComanda = new LineasComandasEntity();
                                        //Añado la lineaComanda al arrayCollection de la comanda
                                        $comanda->getLineasComanda()->add($lineaComanda);
                                        //Introduzco la comanda que he persistido
                                        $lineaComanda->setComanda($comanda);
                                    }
                                    //Si el producto está declarado y no está vacío, actualizo
                                    if (isset($linea['producto']) && !empty($linea['producto'])) {
                                        //Busco el objeto producto por su nombre y lo introduzco en la lineaComanda
                                        $productosRepository = $this->em->getEntityManager()->getRepository(ProductosEntity::class);
                                        $producto = $productosRepository->findProducto($linea['producto']);
                                        $lineaComanda->setProducto($producto);
                                    }
                                    //Si la cantidad está declarada y no está vacía, la actualizo
                                    if (isset($linea['cantidad']) && !empty($linea['cantidad'])) {
                                        $lineaComanda->setCantidad(floatval($linea['cantidad']));
                                    }
                                    //persisto lineaComanda
                                    $this->em->getEntityManager()->persist($lineaComanda);
                                }
                            }
                        }
                        $this->em->getEntityManager()->flush();
                        //Compruebo que la comanda se ha insertado correctamente y lo muestro por pantalla, si no se ha podido insertar saltará un mensaje de error
                        if ($comandaRepository->testInsert($comanda)) {
                            $msg = 'Se ha actualizado la comanda con Id: ' . $comanda->getIdComanda();
                            echo json_encode($msg, http_response_code(201));
                        } else {
                            $msg = 'No se ha podido actualizar la comanda. ';
                            echo $this->main->jsonResponse($method, $msg, 400);
                        }
                    } else {
                        $msg = 'Los comensales no caben en la mesa seleccionada. ';
                        echo $this->main->jsonResponse($method, $msg, 400);
                    }
                } else {
                    $msg = 'La comanda no existe. ';
                    echo $this->main->jsonResponse($method, $msg, 400);
                }
            } else {
                $msg = 'Error al decodificar el archivo json. ';
                echo $this->main->jsonResponse($method, $msg, 500);
            }
        } catch (Exception $e) {
            $msg = 'Error del servidor. ' . $e->getMessage();
            echo $this->main->jsonResponse($method, $msg, 500);
        }
    }
}
/* json para crear la comanda en postman
{
    "fecha":"10/01/2023 12:00:00",
    "mesa":"mesa1",
    "comensales":"3",
    "detalles":"Los comensales tienen prisa",
    "lineas":{
        "1":{
            "producto":"producto1",
            "cantidad":"7"
         },
        "2":{
            "producto":"producto10",
            "cantidad":"10"
        }
   }
}*/

/* json para actualizar la comanda en postman
{
    "mesa":"mesa1",
    "comensales":"3",
    "lineas":{
        "0":{
            "producto":"producto1",
            "cantidad":"7"
         },
        "13":{
            "producto":"producto10",
            "cantidad":"10"
        }
   }
}*/
