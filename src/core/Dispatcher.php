<?php

declare(strict_types=1);

namespace app\Core;

//use DI\Container;
use app\Core\Interfaces\IRequest;
use app\Core\Interfaces\IRoute;

/**
 * Clase que se encarga de gestionar que ruta ha pedido el cliente y que debemos mostrar por pantalla.
 * Para ello, analiza las rutas preconfiguradas y llama al Controlador para que realize su trabajo.
 * Siendo el verdadero cerebro del MVC
 *
 * En esta versión vamos a utilizar un contenedor de PHP-DI
 */
class Dispatcher
{
    //private $container;
    private array $routeList;
    private IRequest $currentRequest;

    public function __construct(/* Container $container, */ IRoute $routeCollection, IRequest $request)
    {
        $this->routeList = $routeCollection->getRoutes();
        $this->currentRequest = $request;
        //$this->container = $container;
        $this->dispatch();
    }

    /**
     * El cerebro de nuestra aplicación, se encarga de lanzar el controlador adecuado para cada ruta solicitada
     * @return void
     */
    private function dispatch(): void{
        //Verificamos que la ruta que hemos recibido está dentro de las rutás de la aplicación
        if(isset($this->routeList[$this->currentRequest->getRoute()])){
            $controllerClass = "app\\Controllers\\".$this->routeList[$this->currentRequest->getRoute()]["controller"];
            //Es equivalente al texto main o detail
            $action = $this->routeList[$this->currentRequest->getRoute()]["action"];
        }else{
            //En caso de no estar predefinida cargaremos el controlador NoRuta para garantizar que nuestra aplicación
            //siempre tiene una vista que mostrar y creamos el namespace correspondiente para poder instanciarlo.
            $controllerClass = "app\\Controllers\\NoRuta";
            $action = "noRuta";
        }
        //Comprobamos que se han enviado o no parámetros por la ruta y lanzamos la acción del controller
        if(!is_null($this->currentRequest->getParams())){
            $params = $this->currentRequest->getParams();          
        }else{
            //No hemos recibimos ningún paramétro.
            $params = null;
        }
        //Instanciamos el controlador que toca
        $controller = new $controllerClass();
        //No instanciamos el controlador, si no usamos la Inyección de dependencias mediante el contenedor para instanciarlo
        //$controller = $this->container->get($controllerClass);
 
        //Ahora ejecutamos el método asociado a la ruta y le pasamos los parámetros.
        $controller->$action(...$params);
    }
}