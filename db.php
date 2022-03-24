<?php
//declare(strict_types=1);

use App\Application\Handlers\HttpErrorHandler;
use App\Application\Handlers\ShutdownHandler;
use App\Application\ResponseEmitter\ResponseEmitter;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;

if(PHP_SAPI != 'cli'){
	exit('Rodar via CLI');
}

require __DIR__ . '/vendor/autoload.php';

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

// Set up settings
$settings = require __DIR__ . '/app/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require __DIR__ . '/app/dependencies.php';
$dependencies($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Instantiate the app
AppFactory::setContainer($container);
$app = AppFactory::create();

$db = $container->get('db');

$schema = $db->schema();
$tabela = 'produtos';

$schema->dropIfExists( $tabela );

// Cria a tabela produtos
$schema->create($tabela, function($table){

	$table->increments('id');
	$table->string('titulo', 100);
	$table->text('descricao');
	$table->decimal('preco', 11, 2);
	$table->string('fabricante', 60);
	$table->date('dt_criacao');
});

$db->table($tabela)->insert([
	'titulo' => 'Smartphone Motorola Moto G6 32GB Dual Chip',
	'descricao' => 'Android Oreo - 8.0 Tela 5.7" Octa-Oreo
		1.8 GHz 4G Câmera 12 + 5MP (Dual Traseira) - Índigo',
	'preco' => 899.00,
	'fabricante' => 'Motorola',
	'dt_criacao' => '2019-10-22'
]);

$db->table($tabela)->insert([
	'titulo' => 'iPhone X Cinza Espacial 64GB',
	'descricao' => 'Tela 5.8" IOS 12 4G Wi-Fi Câmera 12MP -
		Apple',
	'preco' => 4999.00,
	'fabricante' => 'Apple',
	'dt_criacao' => '2020-01-10'
]);