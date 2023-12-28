<?php

namespace app\Repository;

use app\Controllers\MainController;
use Doctrine\ORM\EntityRepository;

class MesaRepository extends EntityRepository
{
        //Método que busca una mesa
        public function findMesa(string $name): mixed
        {
            $mesa = $this->findOneBy(['nombre' => $name]);
            //Si mesa no es null devuelve el objeto, sino lanza un mensaje de error
            if (!is_null($mesa)) {
                return $mesa;
            } else {
                $msg = 'La mesa no existe. ';
                $main=new MainController();
                echo $main->jsonResponse(null, $msg, 400);
            }
        }
}
