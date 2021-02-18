<?php

require_once __DIR__ . '/../Cronograma.php';

class CronogramaApi {

    public static function GetOneByCuitTitular($request, $response, $args) {

        $apiParams = $request->getQueryParams();

        $cronograma = Cronograma::GetByCuilTitular($apiParams["cuil"]);

               
        if($cronograma)
                return $response->withJson($cronograma, 200); 		
            else   
                return $response->withJson(false, 400);
    }

    public static function GetCronogramaByFechaRetiro($request, $response, $args) {

        $apiParams = $request->getQueryParams();
        $fechaDesde = $apiParams['fechaDesde'];
        $fechaHasta = $apiParams['fechaHasta'];
        $idPuntoEntrega = $apiParams['idPuntoEntrega'] ?? null;

        $cronograma = Cronograma::GetCronogramaByFechaRetiro($fechaDesde, $fechaHasta, $idPuntoEntrega); 
               
        if($cronograma)
                return $response->withJson($cronograma, 200); 		
            else   
                return $response->withJson(false, 400);
    }

    public static function GetListadoByFechaAlta($request, $response, $args) {

        $apiParams = $request->getQueryParams();
        $fechaDesde = $apiParams['fechaDesde'];
        $fechaHasta = $apiParams['fechaHasta'];
        $idPuntoEntrega = $apiParams['idPuntoEntrega'] ?? null;
        $estado = $apiParams['estado'] ?? null;

        $cronograma = Cronograma::GetListadoByFechaAlta($fechaDesde, $fechaHasta, $idPuntoEntrega, $estado); 
               
        if($cronograma)
                return $response->withJson($cronograma, 200); 		
            else   
                return $response->withJson(false, 400);
    }
    
}