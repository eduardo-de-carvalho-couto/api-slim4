<?php
declare(strict_types=1);

use App\Application\Middleware\SessionMiddleware;
use Slim\App;
use DI\ContainerBuilder;
use App\Application\Settings\SettingsInterface;

return function (App $app) {
    $app->add(SessionMiddleware::class);

    $containerBuilder = new ContainerBuilder();

    $settings = require __DIR__ . '/../app/settings.php';
    $settings($containerBuilder);

    $container = $containerBuilder->build();

    $settings = $container->get(SettingsInterface::class);
    

    $app->add(new Tuupola\Middleware\JwtAuthentication([
        "header" => "X-Token",
        "regexp" => "/(.*)/",
        "path" => "/api", /* or ["/api", "/admin"] */
        "ignore" => ["/api/token"],
        "secret" => $settings->get('secretKey')
    ]));


    $app->add(function ($request, $handler) {
        $response = $handler->handle($request);
        return $response
                ->withHeader('Access-Control-Allow-Origin', 'http://mysite')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });

};
