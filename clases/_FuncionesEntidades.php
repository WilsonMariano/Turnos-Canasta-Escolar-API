<?php
require_once __DIR__ . "/_AccesoDatos.php";
require_once __DIR__ . "/helpers/PDOHelper.php";
require_once __DIR__ . "/helpers/ErrorHelper.php";
require_once __DIR__ . "/enums/ErrorEnum.php";
foreach (glob(__DIR__ ."/clases/*.php") as $filename)
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

    public static function GetPagedWithOptionalFilter($entityName, $column1, $text1, $column2, $text2, $rows, $page){

		try {  
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 

			$consulta =$objetoAccesoDato->RetornarConsulta("call spGetPagedWithOptionalFilter('$entityName', '$column1', 
				'$text1', '$column2', '$text2', $rows, $page, @o_total_rows)");
	
			$consulta->execute();
			$arrResult= PDOHelper::FetchAll($consulta);	
			$consulta->closeCursor();
			
			$output = $objetoAccesoDato->Query("select @o_total_rows as total_rows")->fetchObject();
				
			//Armo la respuesta
			$result = new \stdClass();
			//Uso ceil() para redondear de manera ascendente
			$result->total_pages = ceil(intval($output->total_rows)/intval($rows));
			$result->total_rows = $output->total_rows;
			$result->data = $arrResult;
			
			return $result;	

		}catch(Exception $e){
			ErrorHelper::LogError(__FUNCTION__, $obj , $e);		 
			throw new ErrorException("No se pudieron recuperar entidades del tipo " . $entityName);
		}
	}
    
}