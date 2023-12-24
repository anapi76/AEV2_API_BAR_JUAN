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

class ComandasController extends AbstractController
{
    private EntityManager $em;
    private MainController $main;

    public function __construct()
    {
        $this->em = new EntityManager();
        $this->main = new MainController();
        parent::__construct();
    }

    public function crearComanda(): void
    {
        //Verificamos que la solicitud viene por post
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'POST') {
            //Obtenemos los datos de la solicitud post
            $jsonData = file_get_contents('php://input');
            //dump($jsonData);
            //decodificamos el json
            $data = json_decode($jsonData, true);
            //dump($data);
            if (!is_null($data)) {
                //dump($data);
                if (isset($data["mesa"]) && !empty($data["mesa"]) && isset($data["comensales"]) && !empty($data["comensales"])) {
                    $comanda = new ComandasEntity();
                    $comanda->setFecha(new DateTime());
                    $mesa = $this->findMesa(intval($data['mesa']));
                    $comanda->setMesa(($mesa));
                    if (isset($data["detalles"]) && !empty($data["detalles"])) {
                        $comanda->setDetalles($data["detalles"]);
                    }
                    if ($data['comensales'] > $mesa->getComensales()) {
                        $msg = 'Los comensales no caben en la mesa seleccionada. ';
                        echo $this->main->json400($method, $msg);
                    } else {
                        $comanda->setComensales(intval($data['comensales']));
                        $this->em->getEntityManager()->persist($comanda);
                        if (isset($data["lineas"]) && !empty($data["lineas"])) {
                            $cont = 0;
                            $lineas = $data["lineas"];
                            foreach ($lineas as $linea) {
                                if (isset($linea) && !empty($linea)) {
                                    $lineasComanda = new LineasComandasEntity();
                                    if (isset($linea['producto']) && !empty($linea['producto']) && isset($linea['cantidad']) && !empty($linea['cantidad'])) {
                                        $producto = $this->findProducto(intval($linea['producto']));
                                        $lineasComanda->setProducto($producto);
                                        $lineasComanda->setCantidad(floatval($linea['cantidad']));
                                        $lineasComanda->setComanda($comanda);
                                        $comanda->getLineasComanda()->add($lineasComanda);
                                        $this->em->getEntityManager()->persist($lineasComanda);
                                        $cont++;
                                    }
                                }
                            }
                            if ($cont > 0) {
                                $this->em->getEntityManager()->flush();
                                $comandaRepository = $this->em->getEntityManager()->getRepository(ComandasEntity::class);
                                if ($comandaRepository->testInsert($comanda)) {
                                    $comandaJSON = $comandaRepository->comandaJSON($comanda);
                                    echo json_encode($comandaJSON, JSON_PRETTY_PRINT);
                                } else {
                                    $msg = 'No se ha podido insertar la comanda. ';
                                    echo $this->main->json400(null, $msg);
                                }
                            } else {
                                $msg = 'No se ha podido crear la comanda, porque faltan lineas. ';
                                echo $this->main->json400(null, $msg);
                            }
                        } else {
                            $msg = 'No se ha podido crear la comanda, porque faltan lineas. ';
                            echo $this->main->json400(null, $msg);
                        }
                    }
                } else {
                    $msg = 'No se ha creado la comanda, porque falta algun parametro. ';
                    echo $this->main->json400(null, $msg);
                }
            } else {
                $msg = 'Error al decodificar el archivo json. ';
                echo $this->main->json400($method, $msg);
            }
        } else {
            $msg = 'El metodo ' . $method . ' no es valido para esta peticion. ';
            echo $this->main->json400($method, $msg);
        }
    }

    public function findMesa(int $id): ?MesaEntity
    {
        $mesaRepository = $this->em->getEntityManager()->getRepository(MesaEntity::class);
        $mesa = $mesaRepository->find($id);
        return $mesa;
    }

    public function findProducto(int $id): ?ProductosEntity
    {
        $productosRepository = $this->em->getEntityManager()->getRepository(ProductosEntity::class);
        $producto = $productosRepository->find($id);
        return $producto;
    }
}



/* {
"mesa":"1",
"comensales":"3",
"detalles":"Alergias alimentarias",
"lineas":{
    "producto":"1",
    "cantidad":"3"
    }
} */
