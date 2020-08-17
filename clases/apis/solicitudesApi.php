<?php

require_once __DIR__ . "/../_AccesoDatos.php";
require_once __DIR__ . "/../_FuncionesEntidades.php";
require_once __DIR__ . "/../Titulares.php";
require_once __DIR__ . "/../Familiares.php";

class SolicitudesApi{

	public static function Insert($request, $response, $args){

        $apiParams = $request->getParsedBody();
        $titular = new Titulares($apiParams["titular"]);
        $error = null;

        //AccesoDatos::beginTransaction();

        // Inserto titular
        $idTitular = Funciones::InsertOne($titular);

        if(!is_numeric($idTitular)) {
            $error = true;
        }

        // Inserto familiares
        foreach ($apiParams["familiares"] as $obj) {
            $familiar = new Familiares($obj);
            $familiar->idTitular = $idTitular;
            $res = Funciones::InsertOne($familiar);

            if(!is_numeric($res)) {
                $error = true;
            }
        }

        if(!$error)
			return $response->withJson(true, 200); 
		else
			return $response->withJson(false, 400); 
    } 
}