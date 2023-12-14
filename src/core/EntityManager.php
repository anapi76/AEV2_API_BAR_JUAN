<?php

declare(strict_types=1);

namespace app\Core;

use Doctrine\ORM\EntityManager as ORMEntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\DBAL\DriverManager;

class EntityManager
{
    private ORMEntityManager $entityManager;

    public function __construct()
    {
        $dbParams = array(
            'host' => $_ENV["db_server"],
            'driver' => $_ENV["db_driver"],
            'user' => $_ENV["db_user"],
            'password' => $_ENV["db_password"],
            'dbname' => $_ENV["db_name"],
        );
        //Indicamos que estamos en modo desarrollo. Cogemos el valor de la configuración
        $isDevMode = boolval($_ENV["DEVELOP_MODE"]);
        //Guardamos la ruta donde estan ubicados todas las entidades.
        $paths = array(__DIR__ . '/../entity');
        $config = ORMSetup::createAttributeMetadataConfiguration($paths, $isDevMode);
        $connection = DriverManager::getConnection($dbParams, $config);
        $this->entityManager = new ORMEntityManager($connection, $config);
    }
    /**
     * Get the value of entityManager
     */ 
    public function getEntityManager()
    {
        return $this->entityManager;
    }
}


