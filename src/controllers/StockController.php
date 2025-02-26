<?php

declare(strict_types=1);

//-- Declaramos el espacio de nombres de cada clase
namespace app\Controllers;

use app\Core\AbstractController;
use app\Core\EntityManager;
use app\Entity\StockEntity;
use DateTime;
use Exception;

class StockController extends AbstractController
{
    //creo una instancia del EntityManager y del MainController
    private EntityManager $em;

    //Inicializo el EntityManager en el constructor
    public function __construct()
    {
        $this->em = new EntityManager();
        parent::__construct();
    }

    //Método que lista la tabla stock, por la última fecha o por una fecha que le damos
    public function stockList(): void
    {
        try{
            $stockRepository = $this->em->getEntityManager()->getRepository(StockEntity::class);
            //Si fecha no está declarado o está vacío, listamos el último stock de cada producto, sino listamos el último stock de cada producto con la fecha que hemos recibido
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
        catch(Exception $e){
            echo 'Error del servidor: '.$e->getMessage();
        }
            
    }
}
