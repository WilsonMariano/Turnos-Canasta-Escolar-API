<?php

class Titulares {

    public $id;
    public $numAfiliado;
    public $nombre;
    public $apellido;
    public $cuil;
    public $domicilio;
    public $localidad;
    public $cuitEmpresa;
    public $razonSocialEmpresa;
    public $telefono;
    public $celular;
    public $email;

    public function __construct($arrData = null){
		if($arrData != null){
            $this->id                   = $arrData["id"] ?? null;
			$this->numAfiliado          = $arrData["numAfiliado"];
            $this->nombre               = $arrData["nombre"];
            $this->apellido             = $arrData["apellido"];
            $this->cuil                 = $arrData["cuil"];
            $this->domicilio            = $arrData["domicilio"];
            $this->localidad            = $arrData["localidad"];
            $this->cuitEmpresa          = $arrData["cuitEmpresa"];
            $this->razonSocialEmpresa   = $arrData["razonSocialEmpresa"];
            $this->telefono             = $arrData["telefono"];
            $this->celular              = $arrData["celular"];
            $this->email                = $arrData["email"];
		}
	}
    
    public function BindQueryParams($consulta, $objEntidad, $includePK = true){
        if($includePK == true)
        $consulta->bindValue(':id'		        ,$objEntidad->id            ,\PDO::PARAM_INT);
        
        $consulta->bindValue(':numAfiliado'             ,$objEntidad->numAfiliado           ,\PDO::PARAM_INT);
        $consulta->bindValue(':nombre'                  ,$objEntidad->nombre                ,\PDO::PARAM_STR);
        $consulta->bindValue(':apellido'                ,$objEntidad->apellido              ,\PDO::PARAM_STR);
        $consulta->bindValue(':cuil'                    ,$objEntidad->cuil                  ,\PDO::PARAM_INT);
        $consulta->bindValue(':domicilio'               ,$objEntidad->domicilio             ,\PDO::PARAM_STR);
        $consulta->bindValue(':localidad'               ,$objEntidad->localidad             ,\PDO::PARAM_STR);
        $consulta->bindValue(':cuitEmpresa'             ,$objEntidad->cuitEmpresa           ,\PDO::PARAM_INT);
        $consulta->bindValue(':razonSocialEmpresa'      ,$objEntidad->razonSocialEmpresa    ,\PDO::PARAM_STR);
        $consulta->bindValue(':telefono'                ,$objEntidad->telefono              ,\PDO::PARAM_INT);
        $consulta->bindValue(':celular'                 ,$objEntidad->celular               ,\PDO::PARAM_INT);
        $consulta->bindValue(':email'                   ,$objEntidad->email                 ,\PDO::PARAM_STR);
    }

    public static function GetByCuil($cuil) {
		
        try{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			
			$consulta = $objetoAccesoDato->RetornarConsulta("select * from Titulares where cuil = :cuil");
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