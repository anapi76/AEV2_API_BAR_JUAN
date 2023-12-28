<?php

namespace app\Repository;

use app\Controllers\MainController;
use Doctrine\ORM\EntityRepository;

class ProductosRepository extends EntityRepository
{
    //Método que busca un producto
    public function findProducto(string $name): mixed
    {
        $producto = $this->findOneBy(['nombre' => $name]);
        //Si producto no es null devuelve el objeto, sino lanza un mensaje de error
        if (!is_null($producto)) {
            return $producto;
        } else {
            $msg = 'El producto no existe. ';
            $main=new MainController();
            echo $main->jsonResponse(null, $msg, 400);
        }
    }
}
