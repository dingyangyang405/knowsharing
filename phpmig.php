<?php

use Codeages\Biz\Framework\Dao\MigrationBootstrap;
use Topxia\StarterKernel;
use Symfony\Component\Yaml\Yaml;

$parameters = Yaml::parse(__DIR__ . '/app/config/parameters.yml');
$parameters = $parameters['parameters'];

$config = [
    'database' => [
        'dbname' => $parameters['database_name'],
        'user' => $parameters['database_user'],
        'password' => $parameters['database_password'],
        'host' => $parameters['database_host'],
        'port' => 3306,
        'driver' => 'pdo_mysql',
        'charset' => 'utf8',
    ]
];

// var_dump($config);exit();

$kernel = new StarterKernel($config);
$kernel->boot();

$bootstrap = new MigrationBootstrap($kernel);

return $bootstrap->boot();
