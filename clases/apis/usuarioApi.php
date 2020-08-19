<?php

include_once __DIR__ . '/../Usuarios.php';
include_once __DIR__ . '/../AutentificadorJWT.php';


class usuarioApi {
       
    public function Login($request, $response, $args) {
        $datosRecibidos = $request->getParsedBody();

        $usuario = new Usuarios();

        $usuario->email      = $datosRecibidos['email'];
        $usuario->password   = $datosRecibidos['password'];

        $usuarioBuscado = Usuarios::Login($usuario);

        if(!$usuarioBuscado) {
            return $response->withJson('Usuario invalido', 404);  

        } else {
            $token = AutentificadorJWT::CrearToken($usuarioBuscado);
            return $response->withJson($token, 200);
        }
    } 
}