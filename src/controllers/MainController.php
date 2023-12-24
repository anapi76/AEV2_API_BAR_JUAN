<?php

declare(strict_types=1);

namespace app\Controllers;

use app\Core\AbstractController;

//-- Clase que se encarga de devolver los datos de la página main
class MainController extends AbstractController
{
    //-- Llamamos al método que nos devuelve todos los datos
    public function main(): void
    {
        //-- Usamos render,el método extendido del AbstractController, para lanzar la plantilla de index.html.twig con las imágenes aleatorias.
        $this->render(
            "index.html.twig",
            [
                'title' => 'AEV2 DWES-DOCTRINE_API_BASICA',
                'strong' => 'BAR JUAN',
                'span' => '',
            ]
        );
    }
    
    public function json400($method,?string $msg): mixed
    {
        $status = 400;
        if (is_null($msg)) {
            $result = 'Peticion invalida: ' . date('d-m-y h:i:s');
        } else {
            $result = $msg . date('d-m-Y H:i:s');
        }
        $jsonArray = array(
            'status' => $status,
            'result' => $result
        );
        $json = json_encode($jsonArray, http_response_code($status));
        return $json;
    }
}