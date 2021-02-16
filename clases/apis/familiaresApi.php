<?php

require_once __DIR__ . '/../Familiares.php';

class FamiliaresApi {

    public static function GetAllByIdTitularFormatter($request, $response, $args) {

        $apiParams = $request->getQueryParams();

        $listado = Familiares::GetAllByIdTitularFormatter($apiParams["idTitular"]);
        
        if($listado)
                return $response->withJson($listado, 200); 		
            else   
                return $response->withJson(false, 400);
    }
    
}