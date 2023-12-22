<?php

declare(strict_types=1);

//-- Declaramos el espacio de nombres de cada clase
namespace app\Controllers;

use app\Core\AbstractController;
use app\Core\EntityManager;
use app\Entity\StockEntity;
use DateTime;

class StockController extends AbstractController
{
    private EntityManager $em;

    public function __construct()
    {
        $this->em = new EntityManager();
        parent::__construct();
    }

    public function stockList():void
    {
        $stockRepository = $this->em->getEntityManager()->getRepository(StockEntity::class);
        if (!isset($_POST['fecha']) || empty($_POST['fecha'])) {
            $stock = $stockRepository->stock();
        } else {
            $fecha = $_POST['fecha'];
            $fechaDateTime = new DateTime($fecha);
            $stock = $stockRepository->stockFechaArray($fechaDateTime);
        }

        $this->render(
            "stockList.html.twig",
            //-- Le pasamos al renderizado los parámetros, que son todos los datos que hemos obtenido del modelo.
            [
                'title' => 'Stock',
                'title1' => 'Stock de productos',
                'resultados' => $stock
            ]
        );
    }
}
