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
}
