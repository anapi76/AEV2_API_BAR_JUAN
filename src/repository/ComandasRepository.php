<?php

namespace app\Repository;

use app\Entity\ComandasEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;

class ComandasRepository  extends EntityRepository
{
    //Método que saca una comanda en formato json
    public function comandaJSON(ComandasEntity $comanda): ?array
    {
        if (is_null($comanda)) {
            $comanda = null;
        } else {
            $estado = ($comanda->isEstado()) ? 'En espera' : 'Finalizada';
            $comandaJSON = array(
                'FECHA' => $comanda->getFecha()->format('d-m-Y H:i:s'),
                'MESA' => $comanda->getMesa()->getNombre(),
                'COMENSALES' => $comanda->getComensales(),
                'DETALLES' => $comanda->getDetalles(),
                'ESTADO' => $estado,
                'LINEAS DE PEDIDO' => $this->lineasComandaJSON($comanda->getLineasComanda())
            );
            return $comandaJSON;
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
                $estado = ($linea->isEntregado()) ? 'Entregado' : 'Pendiente';
                $json[$linea->getIdLinea()] = array(
                    'PRODUCTO' => $linea->getProducto()->getNombre(),
                    'CANTIDAD' => $linea->getCantidad(),
                    'ESTADO' => $estado
                );
            }
            return $json;
        }
    }

    //Método que comprueba si la comanda se ha insertado correctamente en la BD
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
