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
    
}