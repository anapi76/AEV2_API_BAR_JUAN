<?php

namespace app\Repository;

use app\Entity\ComandasEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;

class ComandasRepository  extends EntityRepository
{
    public function comandaJSON(ComandasEntity $comanda): ?array
    {
        if (is_null($comanda)) {
            $comanda= null;
        } else {
            $estado = ($comanda->isEstado()) ? 'Creado' : 'Entregado';
            $comandaJSON = array(
                'FECHA'=>$comanda->getFecha()->format('d-m-Y H:i:s'),
                'MESA'=>$comanda->getMesa()->getIdMesa(),
                'COMENSALES'=>$comanda->getComensales(),
                'DETALLES'=>$comanda->getDetalles(),
                'ESTADO' => $estado,
                'LINEAS DE PEDIDO' => $this->lineasComandaJSON($comanda->getLineasComanda())
            );
            return $comandaJSON;
        }
    }

    public function lineasComandaJSON(?Collection $lineasComanda):?array
    {
        if (is_null($lineasComanda)) {
            $json=null;
        } else {
            $json = array();
            foreach ($lineasComanda as $linea) {
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

    public function testInsert(?ComandasEntity $comanda): bool
    {
        if (empty($comanda) || is_null($comanda)) {
            return false;
        } else {
            $entidad = $this->find($comanda);
            if (empty($entidad))
                return false;
            else {
                return true;
            }
        }
    }

}
