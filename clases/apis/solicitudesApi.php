<?php

require_once __DIR__ . "/../_AccesoDatos.php";
require_once __DIR__ . "/../_FuncionesEntidades.php";
require_once __DIR__ . "/../Titulares.php";
require_once __DIR__ . "/../Familiares.php";
require_once __DIR__ . "/../Cronograma.php";
require_once __DIR__ . "/../_FuncionesEntidades.php";

class SolicitudesApi {

	public static function Insert($request, $response){

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

            // Guardo punto de entrega
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

    public static function Edit($request, $response) {
        $apiParams = $request->getParsedBody();
        $puntoEntrega = new LugaresEntrega($apiParams["puntoEntrega"]);
        $titular = new Titulares($apiParams["titular"]);
        
        // Actualizo titular
        $res = Funciones::UpdateOne($titular);
        
        // Actualizo familiares
        foreach ($apiParams["familiares"] as $obj) {
            $familiar = new Familiares($obj);
            $familiar->id !== ''
                ? Funciones::UpdateOne($familiar)
                : Funciones::InsertOne($familiar);
        }

        // Busco el cronograma
        $cronograma = Funciones::GetOne($titular->id, 'cronograma');
        $cronograma->idPuntoEntrega = $puntoEntrega->id;
        $cronograma->estado = 'ESTADO_SOLICITUD_1';

        // Actualizo el cronograma
        Funciones::UpdateOne($cronograma, 'cronograma');

        return $response->withJson(true, 200); 
    }

    public static function GetOneByCuil($request, $response, $args) {

        $cuilTitular = json_decode($args['cuil']);
        $error = null;
        $familiares = null;
        $puntoEntrega = null;
        $titular = Titulares::GetByCuil($cuilTitular);

        if($titular) {
            $familiares = Familiares::GetAllByIdTitular($titular->id);
            if(sizeof($familiares) > 0) {
                $cronograma = Cronograma::GetByIdTitular($titular->id);
                if($cronograma) {
                    ($cronograma->estado !== 'ESTADO_SOLICITUD_1' && $cronograma->estado !== 'ESTADO_SOLICITUD_3')
                        ? $error = "La solicitud ya fue aprobada, no puede ser modificada"
                        : $puntoEntrega = Funciones::GetOne($cronograma->idPuntoEntrega, 'lugaresentrega');
                } else {
                    $error = "No hay cronograma cargados con el CUIL ingresado";
                }
            } else {
                $error = "No hay familiares cargados con el CUIL ingresado";
            }
        } else {
            $error = "No existe solicitud cargada para el CUIL ingresado";
        }

        if(!$error) {
            $solicitud = array(
                'titular' => $titular,
                'familiares' => $familiares,
                'puntoEntrega' => $puntoEntrega
            );
            return $response->withJson($solicitud, 200); 
        } else {
            return $response->withJson($error, 400); 
        }
    }
}