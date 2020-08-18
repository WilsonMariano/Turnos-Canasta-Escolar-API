<?php

require_once __DIR__ . '/../EmpresasDelegados.php';

class EmpresasDelegadosAPI {

    public static function GetOneByCuit($request, $response, $args) {

        $apiParams = $request->getQueryParams();

        $listado = EmpresasDelegados::GetByCuit($apiParams["cuit"]);
        
        if($listado)
                return $response->withJson(true, 200); 		
            else   
                return $response->withJson(false, 200);
    }
    
}