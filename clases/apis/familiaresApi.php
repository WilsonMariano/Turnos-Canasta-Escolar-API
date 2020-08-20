<?php

require_once __DIR__ . '/../Familiares.php';

class FamiliaresApi {

    public static function GetAllByIdTitular($request, $response, $args) {

        $apiParams = $request->getQueryParams();

        $listado = Familiares::GetAllByIdTitular($apiParams["idTitular"]);
        
        if($listado)
                return $response->withJson($listado, 200); 		
            else   
                return $response->withJson(false, 400);
    }
    
}