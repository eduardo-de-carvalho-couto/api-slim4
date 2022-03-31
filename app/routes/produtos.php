<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Application\Models\Produto;

$app->group('/api/v1', function(Group $group){

	//Lista produtos
    $group->get('/produtos/lista', function(Request $request, Response $response) { 

        $produtos = Produto::get();

        $payload = json_encode($produtos, JSON_PRETTY_PRINT);
        $response->getBody()->write($payload);
            
        return $response->withHeader('Content-Type', 'application/json');
    });

    //Adiciona produto
    $group->post('/produtos/adiciona', function(Request $request, Response $response) { 

        $dados = $request->getParsedBody();
        $produto = Produto::create( $dados );

        $payload = json_encode($produto, JSON_PRETTY_PRINT);
        $response->getBody()->write($payload);
            
        return $response->withHeader('Content-Type', 'application/json');
    });

    //Recupera produto para um determinado ID
    $group->get('/produtos/lista/{id}', function(Request $request, Response $response, array $args) { 

        $produto = Produto::findOrFail( $args['id'] );

        $payload = json_encode($produto, JSON_PRETTY_PRINT);
        $response->getBody()->write($payload);
            
        return $response->withHeader('Content-Type', 'application/json');
    });

    //Atualiza produto para um determinado ID
    $group->put('/produtos/atualiza/{id}', function(Request $request, Response $response, array $args) { 

        $dados = $request->getParsedBody();

        $produto = Produto::findOrFail( $args['id'] );
        $produto->update( $dados );

        $payload = json_encode($produto, JSON_PRETTY_PRINT);
        $response->getBody()->write($payload);
            
        return $response->withHeader('Content-Type', 'application/json');
    });

    //Remove produto para um determinado ID
    $group->get('/produtos/remove/{id}', function(Request $request, Response $response, array $args) { 

        $produto = Produto::findOrFail( $args['id'] );
        $produto->delete();

        $payload = json_encode($produto, JSON_PRETTY_PRINT);
        $response->getBody()->write($payload);
            
        return $response->withHeader('Content-Type', 'application/json');
    }); 	
});
