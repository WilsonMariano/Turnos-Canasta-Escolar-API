<?php

require_once __DIR__ . '/../AutentificadorJWT.php';

class JWTAuth {

  public function VerificarUsuario($request, $response, $next) {

      $token = $request->getQueryParams()['token'];

      try {
        AutentificadorJWT::VerificarToken($token);
      }
      catch(Exception $ex) {
        return $response->withJson($ex->getMessage(), 500);
      }

      return $next($request, $response);
	}    
}