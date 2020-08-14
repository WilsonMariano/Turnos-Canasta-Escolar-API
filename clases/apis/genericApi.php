<?php

require_once __DIR__ . '/../_FuncionesEntidades.php';

class GenericApi{

	public static function GetAll($request, $response, $args){
		// echo "Hola";
		//Traigo  todos los items
		$apiParams = $request->getQueryParams();

		// var_dump($apiParams);
		$listado= Funciones::GetAll($apiParams["t"]);
		
		if($listado)
			return $response->withJson($listado, 200); 		
		else   
			return $response->withJson(false, 400);
	} 
	
	public static function GetPagedWithOptionalFilter($request, $response, $args){
		$apiParams = $request->getQueryParams();

		// var_dump($apiParams['entity']);
		
		$e  = $apiParams['entity'];
		$c1 = $apiParams['col1'] ?? null; 
		$t1 = $apiParams['txt1'] ?? null; 
		$c2 = $apiParams['col2'] ?? null; 
		$t2 = $apiParams['txt2'] ?? null; 
		$r = $apiParams['rows'];
		$p = $apiParams['page'];
					
		$data = Funciones::GetPagedWithOptionalFilter($e, $c1, $t1, $c2, $t2, $r, $p);
		
		if($data)
			return $response->withJson($data, 200); 
		else
			return $response->withJson(false, 400);  
	} 
}