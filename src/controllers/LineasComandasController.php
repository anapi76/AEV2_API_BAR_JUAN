<?php

declare(strict_types=1);

//-- Declaramos el espacio de nombres de cada clase
namespace app\Controllers;

use app\Core\AbstractController;
use app\Core\EntityManager;
use app\Entity\LineasComandasEntity;
use app\Entity\ProductosEntity;
use app\Entity\StockEntity;
use DateTime;
use Exception;

class LineasComandasController extends AbstractController
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

    public function entregadaLineaComanda(string $idLineaComanda)
    {
        //Compruebo el método
        $method = $_SERVER['REQUEST_METHOD'];
        try {
            if ($method === 'PATCH') {
                //Busco la lineaComanda y la comanda que voy a actualizar
                $lineaComandaRepository = $this->em->getEntityManager()->getRepository(LineasComandasEntity::class);
                $lineaComanda = $lineaComandaRepository->find($idLineaComanda);
                //Si la linea comanda no es null obtengo la comanda, sino lanzamos un mensaje de error
                if (!is_null($lineaComanda)) {
                    $comanda = $lineaComanda->getComanda();
                    //si la comanda no es null, actualizo
                    if (!is_null($comanda)) {
                        $producto = $lineaComanda->getProducto();
                        $cantidad = $lineaComanda->getCantidad();
                        //llamo al repositorio de stock para buscar el último stock del producto y la cantidad de ese producto
                        $stockRepository = $this->em->getEntityManager()->getRepository(StockEntity::class);
                        $stockProduct = $stockRepository->stockProducto($producto);
                        $cantidadStock = $stockProduct->getCantidad();
                        //Si la diferencia de productos que hay en la lineaComanda con la cantidad que tenemos en stock es mayor o igual que 0, actualizamos, sino lanzamos un mensaje de error
                        if (($cantidadStock - $cantidad) >= 0) {
                            //Cambio el estado de linea a entregado, persisto y flusheo
                            $lineaComanda->setEntregado(true);
                            $this->em->getEntityManager()->persist($lineaComanda);
                            $this->em->getEntityManager()->flush();
                            //Compruebo si todas las lineasComanda de la comanda están entregadas y cambio el estado de la comanda
                            $lineas = $comanda->getLineasComanda()[0];
                            //Inicializo una variable con true, si alguna línea tiene entregado=false la variable cambiará a false
                            $entregado = true;
                            foreach ($lineas as $linea) {
                                if ($linea->isEntregado() == false) {
                                    $entregado = false;
                                }
                            }
                            //Si todas las lineas están entregadas, cambio el estado de la comanda, persisto y flusheo
                            if ($entregado) {
                                $comanda->setEstado(false);
                                $this->em->getEntityManager()->persist($comanda);
                                $this->em->getEntityManager()->flush();
                            }
                            //Creo un nuevo stock del producto, con la cantidad actualizada y la fecha actual
                            $nuevaCantidad = $cantidadStock - $cantidad;
                            $newStock = new StockEntity();
                            $newStock->setFecha(new DateTime());
                            $newStock->setProducto($producto);
                            $newStock->setCantidad($nuevaCantidad);
                            //Compruebo que se ha actualizado el stock del producto
                            if (($stockRepository->crearStock($newStock))) {
                                $msg = 'Se han creado nuevos stocks';
                                echo json_encode($msg, http_response_code(201));
                            } else {
                                $msg = 'No se ha podido crear el nuevo stock. ';
                                echo $this->main->jsonResponse($method, $msg, 500);
                            }
                        } else {
                            $msg = 'No se puede entregar la lineaComanda porque no hay suficiente stock del producto. ';
                            echo $this->main->jsonResponse($method, $msg, 400);
                        }
                    } else {
                        $msg = 'La comanda no existe. ';
                        echo $this->main->jsonResponse($method, $msg, 400);
                    }
                } else {
                    $msg = 'La linea comanda no existe. ';
                    echo $this->main->jsonResponse($method, $msg, 400);
                }
            } else {
                $msg = 'El metodo ' . $method . ' no es valido para esta peticion. ';
                echo $this->main->jsonResponse($method, $msg, 400);
            }
        } catch (Exception $e) {
            $msg = 'Error del servidor. ' . $e->getMessage();
            echo $this->main->jsonResponse($method, $msg, 500);
        }
    }
}
