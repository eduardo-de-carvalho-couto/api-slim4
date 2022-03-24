<?php
declare(strict_types=1);

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
//use Application\Connection;
//use Application\Models\Produto;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Hello world!');
        return $response;
    });

    $app->group('/users', function (Group $group) {
        $group->get('', ListUsersAction::class);
        $group->get('/{id}', ViewUserAction::class);
    });

    /*
    $app->group('/api/v1', function(Group $group){
        $group->get('/produtos', function(Request $request, Response $response) { 

            $payload = json_encode(['hello' => 'world'], JSON_PRETTY_PRINT);
            $response->getBody()->write($payload);
            
            return $response->withHeader('Content-Type', 'application/json');
        });
    });
    */

    //Produtos
    require __DIR__ . '/../app/routes/produtos.php'; 
};
