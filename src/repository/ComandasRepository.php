<?php

namespace app\Repository;

use app\Entity\ComandasEntity;
use Doctrine\ORM\EntityRepository;

class ComandasRepository  extends EntityRepository
{
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
