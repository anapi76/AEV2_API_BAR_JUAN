<?php

namespace app\Repository;

use app\Entity\TicketsEntity;
use Doctrine\ORM\EntityRepository;
use Doctrine\Common\Collections\Collection;

class TicketsRepository extends EntityRepository
{
    //Método para sacar en formato json un ticket
    public function ticketJSON(TicketsEntity $ticket): ?array
    {
        if (is_null($ticket)) {
            $ticket = null;
        } else {
            $ticketJSON = array(
                $ticket->getIdTicket() => array(
                    'fecha' => $ticket->getFecha()->format('d-m-Y H:i:s'),
                    'idComanda' => $ticket->getComanda()->getIdComanda(),
                    'importe' => $ticket->getImporte()
                ),
                'lineasComanda' => array($this->lineasComandaJSON($ticket->getComanda()->getLineasComanda()))
            );
            return $ticketJSON;
        }
    }

    //Método que saca las líneas de comanda en formato json
    public function lineasComandaJSON(?Collection $lineasComanda): ?array
    {
        if (is_null($lineasComanda)) {
            $json = null;
        } else {
            $json = array();
            foreach ($lineasComanda as $linea) {
                $json[$linea->getIdLinea()] = array(
                    'PRODUCTO' => $linea->getProducto()->getNombre(),
                    'CANTIDAD' => $linea->getCantidad()
                );
            }
            return $json;
        }
    }

    //Método que comprueba si la comanda se ha insertado correctamente en la BD
    public function testInsert(?TicketsEntity $ticket): bool
    {
        if (empty($ticket) || is_null($ticket)) {
            return false;
        } else {
            $entidad = $this->find($ticket);
            if (empty($entidad))
                return false;
            else {
                return true;
            }
        }
    }
}
