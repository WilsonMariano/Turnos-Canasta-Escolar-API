<?php

require_once __DIR__ . '/../Titulares.php';

class TitularesAPI {

    public static function GetOneByCuil($request, $response, $args) {

        $apiParams = $request->getQueryParams();

        $listado = Titulares::GetByCuil($apiParams["cuil"]);
        
        if($listado)
                return $response->withJson(true, 200); 		
            else   
                return $response->withJson(false, 200);
    }
    
}