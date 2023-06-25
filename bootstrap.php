<?php

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AttributeDriver;
use Doctrine\ORM\Tools\Setup;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

require_once "vendor/autoload.php";


function getEntityManager(): EntityManager
{
    $config = new Configuration;

    $queryCache = new ArrayAdapter();
    $metadataCache = new ArrayAdapter();

    $config->setMetadataCache($metadataCache);
    $config->setQueryCache($queryCache);

    $driver = new AttributeDriver([__DIR__ . '/entity']);
    $config->setMetadataDriverImpl($driver);

    $config->setProxyDir(__DIR__ . '/var/cache');
    $config->setProxyNamespace('Cache\Proxies');
    $config->setAutoGenerateProxyClasses(false);


    $connectionOptions = array(
        'driver' => 'pdo_mysql',
        'user' => 'root',
        'password' => '',
        'host' => 'localhost',
        'dbname' => 'project_bd',
    );

    return EntityManager::create($connectionOptions, $config);
}

function outputJson($success, $message, $responseCode = 400)
{
    header("Content-Type: application\json");
    if ($success) {
        echo json_encode(['success' => $success, 'rows' => $message]);
    } else {
        echo json_encode(['success' => $success, 'reason' => $message]);
        http_response_code($responseCode);
    }

}