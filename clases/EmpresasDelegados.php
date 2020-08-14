<?php

require_once __DIR__ . '/helpers/PDOHelper.php';

class EmpresasDelegados {

    public $id;
    public $cuit;
    public $razonSocial;

    public static function GetByCuit($cuit) {


        try{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			
			$consulta = $objetoAccesoDato->RetornarConsulta("select * from empresasDelegados where cuit = :cuit");
			$consulta->bindValue(':cuit' , $cuit, \PDO::PARAM_INT);		
			$consulta->execute();
			$objEntidad= PDOHelper::FetchObject($consulta, static::class);

			return $objEntidad;

		} catch(Exception $e){
			ErrorHelper::LogError(__FUNCTION__, $cuit, $e);		 
			throw new ErrorException("No se pudo recuperar la empresa " . $cuit);
		}
    }
}