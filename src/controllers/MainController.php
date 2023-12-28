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
        //-- Usamos render,el método extendido del AbstractController, para lanzar la plantilla de index.html.twig con los botones stock y pedidos.
        $this->render(
            "index.html.twig",
            [
                'title' => 'AEV2 DWES-DOCTRINE_API_BASICA',
                'strong' => 'BAR JUAN',
                'span' => '',
            ]
        );
    }
    
    //método que devuelve un mensaje de error y el estado
    public function jsonResponse(?string $method, ?string $msg, ?int $status):void
    {
        //Establecemos el código de respuesta si no lo hemos recibido por defecto en 400
        if(is_null($status)){
            $status = 400;
        }
        if(is_null($msg)){
            $result = 'Petición inválida realizada: '.date("d-m-Y-H-i-s");
        }else{
            $result = $msg;
        }

        if(is_null($method)){
            $arrayJson = array(
                'result' => $result
            );
        }else{
            $arrayJson = array(
                'result' => $result,
                'method' => $method
            );
        }
        $json = json_encode($arrayJson, http_response_code($status));

        echo $json;
    }
}