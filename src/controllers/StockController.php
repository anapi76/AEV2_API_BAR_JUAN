<?php

declare(strict_types=1);

//-- Declaramos el espacio de nombres de cada clase
namespace app\Controllers;

use app\Core\AbstractController;
use app\Core\EntityManager;
use app\Entity\StockEntity;

class StockController extends AbstractController
{
    public function stockList()
    {
        $entityManager = (new EntityManager)->getEntityManager();
        $stockRepository = $entityManager->getRepository(StockEntity::class);
        if(!isset($_POST['fecha']) && !isset($_POST['hora'])){
            $stock = $stockRepository->stock();
        }
       else{
        $fecha=$_POST['fecha'];
        $hora=$_POST['hora'];
        $fechaDateTime=$fecha." ".$hora;
        $stock = $stockRepository->stockFecha($fechaDateTime);
       }

        $this->render(
            "stockList.html.twig",
            //-- Le pasamos al renderizado los parámetros, que son todos los datos que hemos obtenido del modelo.
            [
                'title' => 'Stock',
                'title1' => 'Stock',
                'resultados' => $stock
            ]
        );
    }
}
