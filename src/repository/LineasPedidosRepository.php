<?php

namespace app\Repository;

use app\Entity\LineasPedidosEntity;
use Doctrine\ORM\EntityRepository;

class LineasPedidosRepository extends EntityRepository
{
 /*    public function insert(?LineasPedidosEntity $lineasPedido):bool{
        if(empty($lineasPedido)||is_null($lineasPedido)){
            return false;
        }else{
            $entityManager= $this->getEntityManager();
            $entityManager->persist($lineasPedido);
            //$entityManager->flush();
            $entidad = $this->find($lineasPedido->getIdLinea());
            if(empty($entidad))
                return false;
            else{
                return true;
            }
        }
    } */
}
