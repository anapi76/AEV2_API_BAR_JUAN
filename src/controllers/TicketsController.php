<?php

declare(strict_types=1);

//-- Declaramos el espacio de nombres de cada clase
namespace app\Controllers;

use app\Core\AbstractController;
use app\Core\EntityManager;
use app\Entity\ComandasEntity;
use app\Entity\TicketsEntity;
use DateTime;
use Exception;

class TicketsController extends AbstractController
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

    //Método para crear un ticket
    public function crearTicket(string $idComanda = null)
    {
        try {
            //Compruebo el método
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method === 'POST') {
                //si el idComanda no es null empiezo a crear el ticket, sino lanza un mensaje de error
                if (!is_null($idComanda)) {
                    //LLamo al repositorio de comanda y busco la comanda
                    $comandaRepository = $this->em->getEntityManager()->getRepository(ComandasEntity::class);
                    $comanda = $comandaRepository->find(intval($idComanda));
                    //si la comanda no es null pasa a la siguiente comprobación, sino lanza un mensaje de error
                    if (!is_null($comanda)) {
                        //Si el estado de la comanda es false, crea el ticket, sino lanza un mensaje de error
                        if (!($comanda->isEstado())) {
                            $ticket = new TicketsEntity();
                            $ticket->setComanda($comanda);
                            $ticket->setFecha(new DateTime());
                            $lineasComanda = $comanda->getLineasComanda();
                            $comanda->getTickets()->add($ticket);
                            //Recorro las lineas de la comanda para calcular el importe total
                            $importe = 0;
                            foreach ($lineasComanda as $linea) {
                                $cantidad = $linea->getCantidad();
                                $precio = $linea->getProducto()->getPrecio();
                                $total = $precio + $cantidad;
                                $importe += $total;
                            }
                            //Introduzco el importe en el ticket, lo persisto y lo flusheo
                            $ticket->setImporte($importe);
                            $this->em->getEntityManager()->persist($ticket);
                            $this->em->getEntityManager()->flush();
                            $ticketRepository = $this->em->getEntityManager()->getRepository(TicketsEntity::class);
                            //compruebo que el ticket se ha generado correctamente, sino lanza un mensaje de error
                            if ($ticketRepository->testInsert($ticket)) {
                                $ticketJSON = $ticketRepository->ticketJSON($ticket);
                                echo json_encode($ticketJSON, JSON_PRETTY_PRINT);
                            } else {
                                $msg = 'No se ha podido crear el ticket. ';
                                echo $this->main->jsonResponse($method, $msg, 500);
                            }
                        } else {
                            $msg = 'No se puede crear el ticket porque falta lineasPedido por entregar. ';
                            echo $this->main->jsonResponse($method, $msg, 400);
                        }
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
        } catch (Exception $e) {
            $msg = 'Error del servidor. '.$e->getMessage();
            echo $this->main->jsonResponse($method, $msg, 500);
        }
    }
}
