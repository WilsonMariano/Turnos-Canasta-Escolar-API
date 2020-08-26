<?php

require_once __DIR__ . "/../_AccesoDatos.php";
require_once __DIR__ . "/../_FuncionesEntidades.php";
require_once __DIR__ . "/../Titulares.php";
require_once __DIR__ . "/../Familiares.php";
require_once __DIR__ . "/../Cronograma.php";

class SolicitudesApi {

	public static function Insert($request, $response, $args){

        $apiParams = $request->getParsedBody();
        $titular = new Titulares($apiParams["titular"]);
        $error = null;

        $estaRegistrado = Titulares::GetByCuil($titular->cuil);

        if(!$estaRegistrado) {

            // Inserto titular
            $idTitular = Funciones::InsertOne($titular);

            if(!is_numeric($idTitular)) {
                $error = "No se pudo dar de alta el titular";
            }

            // Inserto familiares
            foreach ($apiParams["familiares"] as $obj) {
                $familiar = new Familiares($obj);
                $familiar->idTitular = $idTitular;
                $res = Funciones::InsertOne($familiar);

                if(!is_numeric($res)) {
                    $error = "No se pudieron guardar los familiares";
                }
            }

            // Guardo punto de entrga
            $puntoEntrega = $apiParams["puntoEntrega"];
            
            $cronograma = new Cronograma();
            $cronograma->idPuntoEntrega = $puntoEntrega["id"];
            $cronograma->idTitular = $idTitular;
            $cronograma->estado = "ESTADO_SOLICITUD_1";

            $res = Funciones::InsertOne($cronograma);

            if(!is_numeric($res)) {
                $error = "No se pudo guardar la solicitud";
            }

        } else {
            $error = "El titular ya se ha registrado anteriormente";
        }

        if(!$error)
			return $response->withJson(true, 200); 
		else
			return $response->withJson($error, 400); 
    } 
}