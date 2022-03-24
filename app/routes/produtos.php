<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Application\Models\Produto;

$app->group('/api/v1', function(Group $group){
    $group->get('/produtos/lista', function(Request $request, Response $response) { 

        $produtos = Produto::get();

        $payload = json_encode($produtos, JSON_PRETTY_PRINT);
        $response->getBody()->write($payload);
            
        return $response->withHeader('Content-Type', 'application/json');
    });
});
