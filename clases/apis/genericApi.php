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
}