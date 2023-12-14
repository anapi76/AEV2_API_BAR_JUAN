<?php

declare(strict_types=1);

namespace app\Core;

use app\Core\Interfaces\IRoute;

/**
 * Clase que se encarga de entregarnos todas las rutas predefinidas en la aplicación
 */
class RouteCollection implements IRoute
{

    private array $routes;

    public function __construct()
    {
        $this->importRoutes();
    }

    /**
     * @inheritDoc
     * Nos devuelve un array con todas las rutas y los datos de ellas que están predefinidios en la aplicación
     * en el JSON de rutas
     */
    public function getRoutes(): array
    {
        // TODO: Implement getRoutes() method.
        return $this->routes;
    }

    public function importRoutes():void
    {
        //En vez de utilizar un archivo fijo, utilizamos una variable de entorno de PHP (.env) que podremos configurar
        //dependiendo del tipo de servidor en el que estemos.
        $this->routes = json_decode(file_get_contents(__DIR__."/../../config/".$_ENV["ROUTESFILE"]),true);
    }
}