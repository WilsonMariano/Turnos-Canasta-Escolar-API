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
        //try{
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
			$objEntidad = PDOHelper::FetchObject($consulta, static::class);

			return $objEntidad;

		/*} catch(Exception $e){
			ErrorHelper::LogError(__FUNCTION__, $cuit, $e);		 
			throw new ErrorException("No se pudo recuperar el titular " . $cuit);
		}*/
    }

    public static function GetByIdTitular($idTitular) {
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta = $objetoAccesoDato->RetornarConsulta("
                SELECT *
                FROM Cronograma
                WHERE idTitular = :idTitular
            ");
			$consulta->bindValue(':idTitular' , $idTitular, \PDO::PARAM_INT);		
			$consulta->execute();
			$objEntidad = PDOHelper::FetchObject($consulta, static::class);
			return $objEntidad;
    }

    public static function GetCronogramaByFechaRetiro($fechaDesde, $fechaHasta, $idPuntoEntrega) {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 

        $query = "
        SELECT
            cr.fechaEntrega 'Fecha entrega',
            cr.horaEntrega 'Hora entrega',
            ti.numAfiliado 'Afiliado',
            ti. apellido 'Apellido',
            ti.nombre 'Nombre',
            ti.cuil 'CUIL',
            ti.celular 'Celular',
            ti.cuitEmpresa 'CUIT',
            ti.razonSocialEmpresa 'Empresa',
            fa.apellido 'Apeliido hijo',
            fa.nombre 'Nombre hijo',
            fa.sexo 'Sexo',
            fa.edad 'Edad',
            de.valor 'Nivel',
            CASE fa.usaGuardapolvo
            WHEN true THEN 'Si'
            WHEN false THEN 'No'
            END AS 'Guardapolvo',
            dt.valor 'Talle',
            le.nombre 'Punto entrega',
            ds.valor 'Estado'
        FROM Cronograma cr
        JOIN Titulares ti 		    ON ti.id = cr.idTitular
        JOIN Familiares fa 		    ON fa.idTitular = cr.idTitular
        JOIN LugaresEntrega le	    ON le.id = cr.idPuntoEntrega
        JOIN Diccionario ds 	    ON ds.clave = cr.estado
        JOIN Diccionario de 	    ON de.clave = fa.nivelEducacion
        LEFT JOIN Diccionario dt 	ON dt.clave = fa.talleGuardapolvo
        WHERE cr.fechaEntrega BETWEEN :fechaDesde AND :fechaHasta";            

        !is_null($idPuntoEntrega) 
            && $query .= " AND cr.idPuntoEntrega = :idPuntoEntrega";

        $query .= " ORDER BY cr.fechaEntrega, ti.cuil DESC";

        $consulta = $objetoAccesoDato->RetornarConsulta($query);
        $consulta->bindValue(':fechaDesde' , $fechaDesde, \PDO::PARAM_STR);	
        $consulta->bindValue(':fechaHasta' , $fechaHasta, \PDO::PARAM_STR);	
        !is_null($idPuntoEntrega) ? $consulta->bindValue(':idPuntoEntrega' , $idPuntoEntrega, \PDO::PARAM_INT) : null;
        $consulta->execute();

        $rows = PDOHelper::FetchAll($consulta);

        return $rows;

    }

    public static function GetListadoByFechaAlta($fechaDesde, $fechaHasta, $idPuntoEntrega, $estado) {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 

        $query = "
        SELECT
            ti.fechaAlta 'Fecha alta',
            ti.numAfiliado 'Afiliado',
            ti. apellido 'Apellido',
            ti.nombre 'Nombre',
            ti.cuil 'CUIL',
            ti.celular 'Celular',
            ti.cuitEmpresa 'CUIT',
            ti.razonSocialEmpresa 'Empresa',
            fa.apellido 'Apeliido hijo',
            fa.nombre 'Nombre hijo',
            fa.sexo 'Sexo',
            fa.edad 'Edad',
            de.valor 'Nivel',
            CASE fa.usaGuardapolvo
            WHEN true THEN 'Si'
            WHEN false THEN 'No'
            END AS 'Guardapolvo',
            dt.valor 'Talle',
            le.nombre 'Punto entrega',
            ds.valor 'Estado',
            cr.observaciones 'Observaciones'
        FROM Cronograma cr
        JOIN Titulares ti 		    ON ti.id = cr.idTitular
        JOIN Familiares fa 		    ON fa.idTitular = cr.idTitular
        JOIN LugaresEntrega le	    ON le.id = cr.idPuntoEntrega
        JOIN Diccionario ds 	    ON ds.clave = cr.estado
        JOIN Diccionario de 	    ON de.clave = fa.nivelEducacion
        LEFT JOIN Diccionario dt 	ON dt.clave = fa.talleGuardapolvo
        WHERE ti.fechaAlta BETWEEN :fechaDesde AND :fechaHasta";

        !is_null($estado) 
            && $query .= " AND cr.estado = :estado";

        !is_null($idPuntoEntrega)
            && $query .= " AND cr.idPuntoEntrega = :idPuntoEntrega";     
            
        $query .= " ORDER BY ti.fechaAlta, ti.cuil DESC";

        $consulta = $objetoAccesoDato->RetornarConsulta($query);
        $consulta->bindValue(':fechaDesde' , $fechaDesde, \PDO::PARAM_STR);	
        $consulta->bindValue(':fechaHasta' , $fechaHasta, \PDO::PARAM_STR);	
        !is_null($idPuntoEntrega) ? $consulta->bindValue(':idPuntoEntrega' , $idPuntoEntrega, \PDO::PARAM_INT) : null;	
        !is_null($estado) ? $consulta->bindValue(':estado' , $estado, \PDO::PARAM_STR) : null;	
        $consulta->execute();

        $rows = PDOHelper::FetchAll($consulta);

        return $rows;

    }
}