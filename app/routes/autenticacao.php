<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Application\Models\Produto;
use Application\Models\Usuario;
use Firebase\JWT\JWT;
use App\Application\Settings\SettingsInterface;

//Rotas para geração de tokken
$app->post('/api/token', function(Request $request, Response $response) { 

    $dados = $request->getParsedBody();

    $email = $dados['email'] ?? null;
    $senha = $dados['senha'] ?? null;
    $usuario = Usuario::where('email', $email)->first();

    if( !is_null($usuario) && (md5($senha) === $usuario->senha) ){

    	//gerar token
    	$settings    = $this->get(SettingsInterface::class);
    	$secretKey = $settings->get('secretKey');

    	$usuarioArr = json_decode($usuario, true);

    	$chaveAcesso = JWT::encode($usuarioArr, $secretKey, 'HS256');

    	$payload = json_encode(['chave' => $chaveAcesso], JSON_PRETTY_PRINT);
        $response->getBody()->write($payload);
            
        return $response->withHeader('Content-Type', 'application/json');
	}

	$payload = json_encode(['status' => 'erro'], JSON_PRETTY_PRINT);
    $response->getBody()->write($payload);
            
    return $response->withHeader('Content-Type', 'application/json');
/*

    $usuario = Usuario::where('email', $email)->first();
    
    $payload = json_encode($usuario, JSON_PRETTY_PRINT);
   	$response->getBody()->write($payload);
            
   	return $response->withHeader('Content-Type', 'application/json');
*/
});