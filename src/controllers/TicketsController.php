<?php

declare(strict_types=1);

//-- Declaramos el espacio de nombres de cada clase
namespace app\Controllers;

use app\Core\AbstractController;
use app\Core\EntityManager;
use app\Entity\ComandasEntity;
use app\Entity\TicketsEntity;
use DateTime;

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

    public function crearTicket(string $idComanda=null)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'POST') {
            if (!is_null($idComanda)) {
                $comandaRepository = $this->em->getEntityManager()->getRepository(ComandasEntity::class);
                $comanda = $comandaRepository->find(intval($idComanda));
                if (!is_null($comanda)) {
                    if (!($comanda->isEstado())) {
                        $ticket = new TicketsEntity();
                        $ticket->setComanda($comanda);
                        $ticket->setFecha(new DateTime());
                        $lineasComanda = $comanda->getLineasComanda();
                        $importe = 0;
                        foreach ($lineasComanda as $linea) {
                            $cantidad = $linea->getCantidad();
                            $precio = $linea->getProducto()->getPrecio();
                            $total = $precio + $cantidad;
                            $importe += $total;
                        }
                        $ticket->setImporte($importe);
                        $this->em->getEntityManager()->persist($ticket);
                        $this->em->getEntityManager()->flush();
                        $ticketRepository = $this->em->getEntityManager()->getRepository(TicketsEntity::class);
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
    }
}
