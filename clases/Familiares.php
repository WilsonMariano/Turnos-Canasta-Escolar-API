<?php

class Familiares {

    public $id;
    public $idTitular;
    public $dni;
    public $nombre;
    public $apellido;
    public $fechaNacimiento;
    public $edad;
    public $nivelEducacion;
    public $usaGuardapolvo;
    public $talleGuardapolvo;
    public $sexo;

    public function __construct($arrData = null){
		if($arrData != null){
            $this->id               = $arrData["id"] ?? null;
			$this->idTitular        = $arrData["idTitular"] ?? null;
            $this->dni              = $arrData["dni"];
            $this->nombre           = $arrData["nombre"];
            $this->apellido         = $arrData["apellido"];
            $this->fechaNacimiento  = $arrData["fechaNacimiento"];
            $this->edad             = $arrData["edad"];
            $this->nivelEducacion   = $arrData["nivelEducacion"];
            $this->usaGuardapolvo   = $arrData["usaGuardapolvo"];
            $this->talleGuardapolvo = $arrData["talleGuardapolvo"];
            $this->sexo             = $arrData["sexo"];
		}
	}
    
    public function BindQueryParams($consulta, $objEntidad, $includePK = true){
        if($includePK == true)
        $consulta->bindValue(':id'		          ,$objEntidad->id            ,\PDO::PARAM_INT);
        
        $consulta->bindValue(':idTitular'         ,$objEntidad->idTitular           ,\PDO::PARAM_INT);
        $consulta->bindValue(':dni'               ,$objEntidad->dni                 ,\PDO::PARAM_INT);
        $consulta->bindValue(':nombre'            ,$objEntidad->nombre              ,\PDO::PARAM_STR);
        $consulta->bindValue(':apellido'          ,$objEntidad->apellido            ,\PDO::PARAM_STR);
        $consulta->bindValue(':fechaNacimiento'   ,$objEntidad->fechaNacimiento     ,\PDO::PARAM_STR);
        $consulta->bindValue(':edad'              ,$objEntidad->edad                ,\PDO::PARAM_INT);
        $consulta->bindValue(':nivelEducacion'    ,$objEntidad->nivelEducacion      ,\PDO::PARAM_STR);
        $consulta->bindValue(':usaGuardapolvo'    ,$objEntidad->usaGuardapolvo      ,\PDO::PARAM_INT);
        $consulta->bindValue(':talleGuardapolvo'  ,$objEntidad->talleGuardapolvo    ,\PDO::PARAM_STR);
        $consulta->bindValue(':sexo'              ,$objEntidad->sexo                ,\PDO::PARAM_STR);
    }

    public static function GetAllByIdTitularFormatter($idTitular) {
		
        //try{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			
            $consulta = $objetoAccesoDato->RetornarConsulta("
                SELECT FA.*, DI.clave as 'codNivelEducacion', DI.valor AS 'nivelEducacion', DII.valor AS 'talleGuardapolvo',
                CASE FA.usaGuardapolvo
                    WHEN true THEN 'Si'
                    WHEN false THEN 'No'
                END AS 'usaGuardapolvo'  
                FROM Familiares FA
                INNER JOIN Diccionario DI ON DI.clave = FA.nivelEducacion 
                LEFT JOIN Diccionario DII ON DII.clave = FA.talleGuardapolvo
                WHERE FA.idTitular = :idTitular
            ");
			$consulta->bindValue(':idTitular' , $idTitular, \PDO::PARAM_INT);		
			$consulta->execute();
			$objEntidad = PDOHelper::FetchAll($consulta, static::class);

			return $objEntidad;

		/*} catch(Exception $e){
			ErrorHelper::LogError(__FUNCTION__, $cuit, $e);		 
			throw new ErrorException("No se pudo recuperar el titular " . $cuit);
		}*/
    }

    public static function GetAllByIdTitular($idTitular) {	
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta = $objetoAccesoDato->RetornarConsulta("
            SELECT *
            FROM Familiares
            WHERE idTitular = :idTitular
        ");
        $consulta->bindValue(':idTitular' , $idTitular, \PDO::PARAM_INT);		
        $consulta->execute();
        $objEntidad = PDOHelper::FetchAll($consulta, static::class);
        return $objEntidad;
    }
}