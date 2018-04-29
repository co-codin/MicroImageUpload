<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(__DIR__ . '/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => getenv('APP_DEBUG') === 'true',

        'app' => [
            'name' => getenv('APP_NAME')
        ],

        'database' => [
           'driver' => 'pgsql',
           'host' => 'localhost',
           'port' => 54320,
           'database' => 'microimage',
           'username' => 'homestead',
           'password' => 'secret',
           'charset' => 'utf8',
           'collation' => 'utf8_unicode_ci',
           'prefix' => '',
       ],

    ],
]);

$container = $app->getContainer();

$capsule = new Illuminate\Database\Capsule\Manager();
$capsule->addConnection($container['settings']['database']);

$capsule->setAsGlobal();
$capsule->bootEloquent();

require_once __DIR__ . '/../routes/api.php';
