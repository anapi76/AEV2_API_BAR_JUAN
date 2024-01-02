<?php

namespace app\Repository;

use app\Entity\PedidosEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;

class PedidosRepository extends EntityRepository
{
    //Función que saca un pedido en formato json
    public function pedidoJSON(PedidosEntity $pedido): ?array
    {
        if (is_null($pedido)) {
            $pedido= null;
        } else {
            $estado = ($pedido->isEstado()) ? 'Creado' : 'Entregado';
            $pedidoJSON = array(
                'FECHA' => ($pedido->getFecha())->format('d-m-Y H:i:s'),
                'PROVEEDOR' => $pedido->getProveedor()->getNombre(),
                'DETALLES' => $pedido->getDetalles(),
                'ESTADO' => $estado,
                'LINEAS DE PEDIDO' => $this->lineasPedidoJSON($pedido->getLineasPedido())
            );
            return $pedidoJSON;
        }
    }

    //Función que saca las líneas de pedido en formato json
    public function lineasPedidoJSON(?Collection $lineasPedido):?array
    {
        if (is_null($lineasPedido)) {
            $json=null;
        } else {
            $json = array();
            foreach ($lineasPedido as $linea) {
                $estado = ($linea->isEntregado()) ? 'Creado' : 'Entregado';
                $json[$linea->getIdLinea()] = array(
                    'PRODUCTO' => $linea->getProducto()->getNombre(),
                    'CANTIDAD' => $linea->getCantidad(),
                    'ESTADO'=>$estado
                );
            }
            return $json;
        }
    }

    //Función que lista todos los pedidos en formato json
    public function listarPedidosJSOn():?array
    {
      
        $pedidos = $this->findAll();
        if (is_null($pedidos)) {
            $json=null;
        } else {
            $json = array();
            foreach ($pedidos as $pedido) {
                $estado = ($pedido->isEstado()) ? 'Creado' : 'Entregado';
                $json[$pedido->getIdPedidos()] = array(
                    'FECHA' => ($pedido->getFecha())->format('d-m-Y H:i:s'),
                    'PROVEEDOR' => $pedido->getProveedor()->getNombre(),
                    'DETALLES' => $pedido->getDetalles(),
                    'ESTADO' => $estado,
                    'LINEAS DE PEDIDO' => $this->lineasPedidoJSON($pedido->getLineasPedido())
                );
            }
            return $json;
        }
    
    }

    //Función que comprueba si el pedido se ha insertado correctamente en la BD
    public function testInsert(?PedidosEntity $pedido): bool
    {
        if (empty($pedido) || is_null($pedido)) {
            return false;
        } else {
            $entidad = $this->find($pedido);
            if (empty($entidad))
                return false;
            else {
                return true;
            }
        }
    }
}
