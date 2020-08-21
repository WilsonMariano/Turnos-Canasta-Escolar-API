<?php

    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;
    require 'vendor/autoload.php';

    require_once __DIR__ . '/clases/middlewares/jwtAuth.php';

    //Incluir todas las apis creadas
    foreach (glob("clases/apis/*.php") as $filename){
        require_once $filename;
    }

    $config['displayErrorDetails'] = true;
    $config['addContentLengthHeader'] = false;

    $app = new \Slim\App(["settings" => $config]);

    $app->add(function ($req, $res, $next){
		$response = $next($req, $res);
		return $response
		->withHeader('Access-Control-Allow-Origin', 'http://localhost:4200')
		->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
		->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });
    
    //Test method
	$app->get('/ok', function (Request $request, Response $response, $args) {
		$response->getBody()->write("OK", 200);
		return $response;
	});

    //Generic
    $app->group('/generic', function () {
        $this->get('/one/{id}',     \GenericApi::class . ':GetOne');    
        $this->get('/all[/]',       \GenericApi::class . ':GetAll');  
        $this->get('/paged[/]',     \GenericApi::class . ':GetPagedWithOptionalFilter');         
        $this->put('/put[/]',       \GenericApi::class . ':UpdateOne')->add(\JWTAuth::class . ':VerificarUsuario');;       
    });

    $app->group('/empresasDelegados', function () {
		  $this->get('/one[/]',     \EmpresasDelegadosApi::class . ':GetOneByCuit');         
    });

    $app->group('/solicitudes', function () {
        $this->post('/insert[/]',   \SolicitudesApi::class . ':Insert');         
    });

    $app->group('/titulares', function () {
        $this->get('/one[/]',       \TitularesApi::class . ':GetOneByCuil');         
    });

    $app->group('/familiares', function () {
		$this->get('/all[/]',       \FamiliaresApi::class . ':GetAllByIdTitular');      
    });
    
    $app->group('/cronograma', function () {
        $this->get('/one[/]',       \CronogramaApi::class . ':GetOneByCuitTitular');        
    });

	$app->group('/usuarios', function () {
		$this->post('/login[/]',    \UsuarioApi::class . ':Login');      
	});


    $app->run();