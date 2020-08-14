<?php
require_once "helpers\PDOHelper.php";
require_once "helpers\ErrorHelper.php";
require_once "enums\ErrorEnum.php";
foreach (glob("clases\*.php") as $filename)
    require_once $filename;
    
class Funciones {

    public static function GetAll($entityName) {    

        try {  
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta('select * from ' .$entityName);
            $consulta->execute();	
            $arrObjEntidad= PDOHelper::FetchAll($consulta, $entityName);	
            
            return $arrObjEntidad;
    
        }catch(Exception $e){
            ErrorHelper::LogError(ErrorEnum::GenericGet, $obj , $e);		 
            throw new ErrorException("No se pudieron recuperar entidades del tipo " . $entityName);
        }
    }
    
}