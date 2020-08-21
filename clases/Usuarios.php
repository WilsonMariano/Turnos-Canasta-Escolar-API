<?php

require_once __DIR__ . "/_AccesoDatos.php";
//require_once __DIR__ . '/helpers/ErrorHelper.php';
require_once __DIR__ . '/helpers/PDOHelper.php';


class Usuarios {

	public $id;
	public $email;
    public $password;

    public static function Login($usuario) {
		//try{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select * from " . static::class .
				" where email = :email AND password = :password");
			$consulta->bindValue(':email',      $usuario->email,    PDO::PARAM_STR);
			$consulta->bindValue(':password',   $usuario->password, PDO::PARAM_STR);
			$consulta->execute();

			$usuarioBuscado = PDOHelper::FetchObject($consulta, static::class);

			return $usuarioBuscado;
		
		/*} catch(Exception $e){
			ErrorHelper::LogError(__FUNCTION__, $usuario, $e);		 
			throw new ErrorException("No se pudo iniciar sesión");
		}*/
	}
}
