<?php

class Cronograma {

    public $id;
    public $idTitular;
    public $idPuntoEntrega;
    public $fechaEntrega;
    public $horaEntrega;
    public $estado;
    public $observaciones;

    public function __construct($arrData = null){
		if($arrData != null){
            $this->id               = $arrData["id"] ?? null;
			$this->idTitular        = $arrData["idTitular"];
            $this->idPuntoEntrega   = $arrData["idPuntoEntrega"];
            $this->fechaEntrega     = $arrData["fechaEntrega"];
            $this->horaEntrega      = $arrData["horaEntrega"];
            $this->estado           = $arrData["estado"];
            $this->observaciones    = $arrData["observaciones"];
		}
	}

    
    public function BindQueryParams($consulta, $objEntidad, $includePK = true){
        if($includePK == true)
        $consulta->bindValue(':id'		        ,$objEntidad->id            ,\PDO::PARAM_INT);
        
        $consulta->bindValue(':idTitular'       ,$objEntidad->idTitular     ,\PDO::PARAM_INT);
        $consulta->bindValue(':idPuntoEntrega'  ,$objEntidad->idPuntoEntrega,\PDO::PARAM_INT);
        $consulta->bindValue(':fechaEntrega'    ,$objEntidad->fechaEntrega  ,\PDO::PARAM_STR);
        $consulta->bindValue(':horaEntrega'     ,$objEntidad->horaEntrega   ,\PDO::PARAM_STR);
        $consulta->bindValue(':estado'          ,$objEntidad->estado        ,\PDO::PARAM_STR);
        $consulta->bindValue(':observaciones'   ,$objEntidad->observaciones ,\PDO::PARAM_STR);
    }

    public static function GetByCuilTitular($cuil) {
        try{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			
            $consulta = $objetoAccesoDato->RetornarConsulta("
                SELECT C.*, D.valor as 'estadoDescripcion', LE.nombre as 'nombrePunto', 
                LE.domicilio as 'domicilioPunto' FROM Cronograma as C
                INNER JOIN Titulares as T
                ON C.idTitular = T.id
                INNER JOIN Diccionario as D
                ON C.estado = D.clave
                INNER JOIN LugaresEntrega as LE
                ON C.idPuntoEntrega = LE.id
                where T.cuil = :cuil
            ");
			$consulta->bindValue(':cuil' , $cuil, \PDO::PARAM_INT);		
			$consulta->execute();
			$objEntidad= PDOHelper::FetchObject($consulta, static::class);

			return $objEntidad;

		} catch(Exception $e){
			ErrorHelper::LogError(__FUNCTION__, $cuit, $e);		 
			throw new ErrorException("No se pudo recuperar el titular " . $cuit);
		}
    }
}