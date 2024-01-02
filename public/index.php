<?php
//Incluimos un archivo que hemos generado para poder hacer autoload y usar los nombres de espacio.
require_once "../vendor/autoload.php";

use app\Controllers\MainController;
use app\Core\Dispatcher;
use app\Core\RouteCollection;
use app\Core\Request;
use Dotenv\Dotenv;

//Cargamos las variables de entorno con el DotEnv del archivo .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../config/');
$dotenv->load();
//Creamos un objeto que contenga todas las rutas de la aplicación.
$routes = new RouteCollection();
//Creamos un objeto que contenga la ruta que hemos recibido desde el navegador.
$request = new Request();
//Lanzo un bloque try catch para capturar el error en caso de que no se pueda conectar a la BD
try {
    //Ahora creamos un objeto que se encarga de redirigir al controller que corresponda la aplicación
    $dispatcher = new Dispatcher($routes, $request);
} catch (Throwable $e) {
    $main = new MainController();
    echo $main->jsonResponse(null, 'Error de conexion a la base de datos', 500);
}
