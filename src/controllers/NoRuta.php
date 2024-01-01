<?php

declare(strict_types=1);

namespace app\Controllers;

use app\Core\AbstractController;

//-- Clase que devuelve los datos de error, cuando se introduce una ruta no válida
class NoRuta extends AbstractController
{
    //-- Llamamos al método que nos devuelve todos los datos
    public function noRuta()
    {
        //-- Usamos render,el método extendido del AbstractController, para lanzar la plantilla de index.html.twig con las imágenes aleatorias.
        $this->render(
            "index.html.twig",
            [
                'title' => 'Ruta no disponible',
                'strong' => 'Ruta',
                'span' => 'no disponible'
            ]
        );
    }
}
