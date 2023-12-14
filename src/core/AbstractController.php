<?php

declare(strict_types=1);

namespace app\Core;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\Extra\Intl\IntlExtension;

/**
 * Clase abstracta que nos permite extender de ella para crear cualquier controller en nuestra aplicación.
 * Es nuestro controlador padre.
 */
abstract class AbstractController
{
    private Environment $twigEnvironment;

    public function __construct()
    {
        //Estas dos líneas nos indica la documentación de Twig que debemos añadirlas para poder usarlo en cada controller
        //En vez de utilizar un archivo fijo, utilizamos una variable de entorno de PHP (.env) que podremos configurar
        //dependiendo del tipo de servidor en el que estemos.
        $loader = new FilesystemLoader(__DIR__ . "/../" . $_ENV["TEMPLATESFOLDER"]);
        $this->twigEnvironment = new Environment($loader);
        $this->twigEnvironment->addExtension(new IntlExtension());
    }

    /**
     * Método que simplifica el renderizado de twig que podemos usar en cualquier controller que extienda esta clase
     * abstracta. Gracias a este método reutilizamos el código en cada uno de los controladores.
     * @param string $template
     * @param array $params
     * @return void
     */
    public function render(string $template, array $params): void
    {
        //$templateTWIG = $this->twigEnvironment->load($template);
        //echo $templateTWIG->render($params);
        echo $this->twigEnvironment->render($template, $params);
    }
    
}