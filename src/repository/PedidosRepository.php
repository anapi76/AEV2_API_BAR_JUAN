<?php

namespace app\Repository;

use app\Entity\PedidosEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;

class PedidosRepository extends EntityRepository
{
    public function pedidoJSON(PedidosEntity $pedido): mixed
    {
        if (is_null($pedido)) {
            return null;
        } else {
            $estado=($pedido->isEstado())?'Entregado':'Pendiente';
            $pedidoJSON = array(
                'PROVEEDOR'=>$pedido->getProveedor()->getNombre(),
                'FECHA'=>($pedido->getFecha())->format('d-m-Y'),
                'HORA'=>($pedido->getFecha())->format('H:m:s'),
                'DETALLES'=>$pedido->getDetalles(),
                'ESTADO'=>$estado,
                'LINEAS DE PEDIDO'=>$this->lineasPedidosJSON($pedido->getLineasPedido())
            );
            return $pedidoJSON;
        }
    }

    public function lineasPedidosJSON(?Collection $lineasPedido){
       
        if (is_null($lineasPedido)) {
            return null;
        } else {
            $json = array();
            foreach ($lineasPedido as $linea) {
                dump($linea->getIdLinea());
                $json[$linea->getIdLinea()] = array(
                    'PRODUCTO' => $linea->getProducto()->getNombre(),
                    'CANTIDAD' => $linea->getCantidad()
                );
            }
            return $json;
        }
    }


    /* public function insert(?PedidosEntity $pedido): bool
    {
        if (empty($pedido) || is_null($pedido)) {
            return false;
        } else {
            $entityManager = $this->getEntityManager();
            $entityManager->persist($pedido);
            $entityManager->flush();
            $entidad = $this->find($pedido->getIdPedidos());
            if (empty($entidad))
                return false;
            else {
                return true;
            }
        }
    } */
}
